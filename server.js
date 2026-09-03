import express from "express";
import cors from "cors";

const app = express();

app.use(
  cors({
    origin: "http://localhost:5500",
    credentials: true,
  }),
);
app.use(express.json());


app.post("/api/users", async (req, res) => {
    const frontendPayload = req.body;
    const phpResponse = await fetch("http://127.0.0.1:8000/UserController.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(frontendPayload),
    });

    const phpData = await phpResponse.json();;
    res.send(phpData);
});

app.get('/api/users', async (req, res) => {
    console.log("COOKIE FROM BROWSER:", req.headers.cookie);
    const response = await fetch("http://127.0.0.1:8000/UserController.php", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        "Cookie": req.headers.cookie,
      },
    });

    const result = await response.json();
    res.send(result);
});

app.post("/api/login", async (req, res) => {
  const frontendPayload = req.body; 
  console.log('JS BODY: ', frontendPayload);
  const response = await fetch("http://127.0.0.1:8000/LoginController.php", {
    method: "POST",
    headers: { "Content-Type": "application/json", "Cookie": req.headers.cookie },
    body: JSON.stringify(frontendPayload),
  });

   const result = await response.json();

    const sessionCookie = response.headers.get("set-cookie");
    if (sessionCookie) {
    res.set("Set-Cookie", sessionCookie);
    }
  res.json(result);
});

app.post("/api/signup", async (req, res) => {
  const frontendPayload = req.body; 
  console.log(frontendPayload);
  const response = await fetch("http://127.0.0.1:8000/SignUpController.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(frontendPayload), 
  });

  const result = await response.json();

  console.log("REQUEST: ", req.headers);
  res.json(result);
});

app.get("/api/me", async (req, res) => {
  const response = await fetch("http://127.0.0.1:8000/MeController.php", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Cookie: req.headers.cookie,
    },
  });

  const result = await response.json();
  console.log(response)
  res.json(result);
});

app.post("/api/logout", async (req, res) => {
  const response = await fetch("http://127.0.0.1:8000/LogoutController.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Cookie: req.headers.cookie,
    },
  });

  const result = await response.json();

  const sessionCookie = response.headers.get("set-cookie");
  if (sessionCookie) {
    res.set("Set-Cookie", sessionCookie);
  }

  res.json(result);
});

app.post('/api/tasks', async (req, res) => {
    const payload = req.body;
    const response = await fetch(
      "http://127.0.0.1:8000/toDoListController.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Cookie": req.headers.cookie,
        },
        body: JSON.stringify(payload)
      },
    );

    const result = await response.json();
    res.send(result);

});

app.delete('/api/tasks/:id', async (req, res) => {
    const payload = req.params.id;
    const response = await fetch(
      `http://127.0.0.1:8000/toDoListController.php?taskID=${taskId}`,
      {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          "Cookie": req.headers.cookie,
        },
      },
    );

    const result = await response.json();
    res.send(result);

});

app.delete('/api/tasks', async (req, res) => {
    const response = await fetch(
      "http://127.0.0.1:8000/toDoListController.php",
      {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
          "Cookie": req.headers.cookie,
        },
      },
    );

    const result = await response.text();
    res.send(result);

});

app.get("/api/tasks", async (req, res) => {
    const response = await fetch( "http://127.0.0.1:8000/toDoListController.php", {
        method: 'GET',
        headers: {
          "Content-Type": "application/json",
          "Cookie": req.headers.cookie,
        },
    });

    const result = await response.json();
    console.log("TASK API RESULT: ", result);
    res.send(result);
});

app.patch("/api/tasks/:id", async (req, res) => {

    const taskId = req.params.id;
    const payload = req.body;

    const response = await fetch(
      `http://127.0.0.1:8000/toDoListController.php?taskId=${taskId}`,
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

app.listen(3000, () => console.log("Node Gateway running on port 3000"));


