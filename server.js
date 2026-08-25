import express from "express";

const app = express();

app.use(express.json());

app.post("/api/", async (req, res) => {
  res.json({ data: "field" });
});

app.listen(3000, () => console.log("Node Gateway running on port 3000"));
