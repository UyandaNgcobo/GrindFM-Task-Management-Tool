import express from "express";
import cors from "cors";
import swaggerJsdoc from "swagger-jsdoc";
import swaggerUi from "swagger-ui-express";
import "dotenv/config";

const app = express();

const allowedOrigins = process.env.FRONTEND_CORS_URL.split(",").map((url) =>
  url.trim(),
);

app.use(
  cors({
    origin: function (origin, callback) {
      // If the origin is in our list (or if there is no origin), allow it
      if (!origin || allowedOrigins.includes(origin)) {
        callback(null, true);
      } else {
        callback(new Error("Not allowed by CORS"));
      }
    },
    credentials: true,
  }),
);
app.use(express.json());

// --- SWAGGER SETUP START ---
const swaggerOptions = {
  definition: {
    openapi: "3.0.0",
    info: {
      title: "To-Do List API Gateway",
      version: "1.0.0",
      description:
        "API documentation for the Node.js Gateway routing to the PHP backend",
    },

    tags: [
      {
        name: "Auth",
        description: "Endpoints for login, signup, and session management",
      },
      {
        name: "Tasks",
        description:
          "Everything related to creating and managing the to-do list",
      },
      {
        name: "Reminders",
        description: "Create and manage user reminders",
      },
    ],
    // --------------------------------
    servers: [
      {
        url: "http://localhost:3000",
      },
    ],
  },
  apis: ["./*.js"],
};

const swaggerSpec = swaggerJsdoc(swaggerOptions);
app.use(
  "/api-docs",
  swaggerUi.serve,
  swaggerUi.setup(swaggerSpec)
);
// --- SWAGGER SETUP END ---

app.post("/api/users", async (req, res) => {
  const frontendPayload = req.body;
  const phpResponse = await fetch(
    "http://127.0.0.1:8000/Controllers/UserController.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(frontendPayload),
    },
  );

  const phpData = await phpResponse.json();
  res.send(phpData);
});

/**
 * @swagger
 * /api/login:
 *   post:
 *     tags: [Auth]
 *     summary: Log user in.
 *     description: Logs a user in by email and password.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               email:
 *                 type: string
 *                 example: "example@gmail.com"
 *               password:
 *                 type: string
 *                 example: "secret123"
 *     responses:
 *       200:
 *         description: Successfully logged in
 */
app.post("/api/login", async (req, res) => {
  const frontendPayload = req.body;
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/LoginController.php`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
      body: JSON.stringify(frontendPayload),
    },
  );

  const result = await response.json();
  console.log("LOGIN ATTEMPT:", result)

  const sessionCookie = response.headers.get("set-cookie");
  if (sessionCookie) {
    res.set("Set-Cookie", sessionCookie);
  }
  res.json(result);
});

/**
 * @swagger
 * /api/signup:
 *   post:
 *     tags: [Auth]
 *     summary: Sign user up
 *     description: Signs a new user up.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               username:
 *                 type: string
 *                 example: "ladiesman217"
 *               email:
 *                 type: string
 *                 example: "example@gmail.com"
 *               password:
 *                 type: string
 *                 example: "secret123"
 *     responses:
 *       200:
 *         description: Successfully signed up
 */
app.post("/api/signup", async (req, res) => {
  const frontendPayload = req.body;
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/SignUpController.php`,
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(frontendPayload),
    },
  );

  const result = await response.json();
  res.json(result);
});

/**
 * @swagger
 * /api/logout:
 *   post:
 *     tags: [Auth]
 *     summary: Log user out
 *     description: Adds a new task to the to-do list.
 *     responses:
 *       200:
 *         description: Successfully Logged out
 */
app.post("/api/logout", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/LogoutController.php`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();

  const sessionCookie = response.headers.get("set-cookie");
  if (sessionCookie) {
    res.set("Set-Cookie", sessionCookie);
  }

  res.json(result);
});

/**
 * @swagger
 * /api/users:
 *   get:
 *     tags: [Auth]
 *     summary: Get all users
 *     description: Gets all users in database.
 *     responses:
 *       200:
 *         description: Successfully retrieved all users
 */
app.get("/api/users", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/UserController.php`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  console.log("PHP RESPONSE: ", result)
  res.send(result);
});

/**
 * @swagger
 * /api/me:
 *   get:
 *     tags: [Auth]
 *     summary: Return User ID
 *     description: Retrieves current user ID from session.
 *     responses:
 *       200:
 *         description: User ID retrieved!
 */
app.get("/api/me", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/MeController.php`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  res.json(result);
});

/**
 * @swagger
 * /api/tasks:
 *   post:
 *     tags: [Tasks]
 *     summary: Create a new task
 *     description: Adds a new task to the to-do list.
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               title:
 *                 type: string
 *                 example: "Buy groceries"
 *               description:
 *                 type: string
 *                 example: "Milk, eggs, and bread"
 *     responses:
 *       200:
 *         description: Task successfully created
 */
app.post("/api/tasks", async (req, res) => {
  const payload = req.body;
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/toDoListController.php`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
      body: JSON.stringify(payload),
    },
  );

  const result = await response.json();
  res.send(result);
});

/**
 * @swagger
 * /api/tasks/{id}:
 *   patch:
 *     tags: [Tasks]
 *     summary: Update task description
 *     description: Modifies a task's description.
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: The ID of the task to update
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               description:
 *                 type: string
 *                 example: "I actually want to relax."
 *     responses:
 *       200:
 *         description: Task successfully updated
 */
app.patch("/api/tasks/:id", async (req, res) => {
  const taskId = req.params.id;
  const payload = req.body;

  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/toDoListController.php?taskId=${taskId}`,
    {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
      body: JSON.stringify(payload),
    },
  );

  const result = await response.json();
  res.send(result);
});

/**
 * @swagger
 * /api/tasks:
 *   get:
 *     tags: [Tasks]
 *     summary: Get all tasks
 *     description: Fetches all to-do list tasks from the backend.
 *     responses:
 *       200:
 *         description: Retrieved all tasks
 */

app.get("/api/tasks", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/toDoListController.php`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  console.log(result);
  res.send(result);
});

/**
 * @swagger
 * /api/tasks/{id}:
 *   delete:
 *     tags: [Tasks]
 *     summary: Delete a task
 *     description: Removes a specific task by its ID.
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: The ID of the task to delete
 *     responses:
 *       200:
 *         description: Task successfully deleted
 */
app.delete("/api/tasks/:id", async (req, res) => {
  const taskId = req.params.id;
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/toDoListController.php?taskId=${taskId}`,
    {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  res.send(result);
});

/**
 * @swagger
 * /api/tasks:
 *   delete:
 *     tags: [Tasks]
 *     summary: Delete all tasks
 *     description: Removes task task by User ID
 *     responses:
 *       200:
 *         description: Tasks successfully deleted
 */
app.delete("/api/tasks", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/toDoListController.php`,
    {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.text();
  res.send(result);
});

/**
 * @swagger
 * /api/reminders:
 *   post:
 *     tags: [Reminders]
 *     summary: Create a new reminder
 *     description: Creates a new reminder
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               title:
 *                 type: string
 *                 example: "Do something on Wed at 18:00"
 *               description:
 *                 type: string
 *                 example: "I actually want to relax."
 *               trigger_at:
 *                 type: string
 *                 format: date-time
 *                 example: "2026-09-15 10:10:10"
 *     responses:
 *       200:
 *         description: Reminder successfully updated
 */
app.post("/api/reminders", async (req, res) => {
  const payload = req.body;

  console.log(payload);

  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/reminderController.php`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
      body: JSON.stringify(payload),
    },
  );

  const result = await response.json();
  console.log(result);
  res.send(result);
});


/**
 * @swagger
 * /api/reminders:
 *   get:
 *     tags: [Reminders]
 *     summary: get all reminders
 *     description: Gets all reminders based on User ID
 *     responses:
 *       200:
 *         description: All reminders successfully retrieved
 */
app.get("/api/reminders", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/reminderController.php`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  // console.log(result);
  res.send(result);
});



/**
 * @swagger
 * /api/reminders:
 *   delete:
 *     tags: [Reminders]
 *     summary: Delete all reminders
 *     description: Deletes all reminders based on User ID.
 *     responses:
 *       200:
 *         description: All reminders successfully deleted
 */
app.delete("/api/reminders", async (req, res) => {
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/reminderController.php`,
    {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  console.log(result);
  res.send(result);
});


/**
 * @swagger
 * /api/reminders/{id}:
 *   delete:
 *     tags: [Reminders]
 *     summary: Delete a reminder
 *     description: Deletes a reminder based on User ID and its own ID.
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: The ID of the reminder to delete
 *     responses:
 *       200:
 *         description: Reminder successfully deleted
 */
app.delete("/api/reminders/:id", async (req, res) => {
  const taskId = req.params.id;

  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/reminderController.php?taskId=${taskId}`,
    {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
    },
  );

  const result = await response.json();
  console.log(result);
  res.send(result);
});


/**
 * @swagger
 * /api/reminders/{id}:
 *   patch:
 *     tags: [Reminders]
 *     summary: Update reminder description
 *     description: Modifies a reminder's description based on its ID.
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *         description: The ID of the reminder to update
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           schema:
 *             type: object
 *             properties:
 *               description:
 *                 type: string
 *                 example: "I actually want to relax."
 *     responses:
 *       200:
 *         description: Reminder successfully updated
 */
app.patch("/api/reminders/:id", async (req, res) => {
  const reminderId = req.params.id;
  const payload = req.body;

  console.log(payload)

  // const payload = body.params;
  const response = await fetch(
    `${process.env.PHP_BACKEND_URL}/Controllers/reminderController.php?reminderId=${reminderId}`,
    {
      method: "PATCH",
      headers: {
        "Content-Type": "application/json",
        Cookie: req.headers.cookie,
      },
      body: JSON.stringify(payload),
    },
  );

  const result = await response.text();
  console.log("PHP RESPONSE", result);
  res.send(result);
});

const PORT = process.env.NODE_PORT || 4000;
app.listen(PORT, "0.0.0.0", () =>
  console.log(`Node Gateway running on port ${PORT}`),
);
