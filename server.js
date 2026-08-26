import express from "express";
import cors from "cors";

const app = express();

app.use(cors());
app.use(express.json());

app.post("/api/users", async (req, res) => {
    const frontendPayload = req.body;

    const phpResponse = await fetch("http://127.0.0.1:8000/UserController.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(frontendPayload),
    });

    const phpData = await phpResponse.text();;
    res.send(phpData);
});

app.get('/api/users', async (req, res) => {

    const response = await fetch("http://127.0.0.1:8000/UserController.php", {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    const result = await response.json();
    console.log("PHP RESPONSE:", result);
    res.send(result);
});

app.get("/api/login", async (req, res) => {

});

app.listen(3000, () => console.log("Node Gateway running on port 3000"));
