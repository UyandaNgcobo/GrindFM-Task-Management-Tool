# Run GrindFM with Docker Compose

Docker Compose starts the PHP frontend, Node API gateway, PHP controller service,
and MySQL database together.

1. Make sure the ignored `.env` file has `DB_NAME` and a non-empty `DB_PASS`.
   Copy `.env.example` if you need a starting point. The Compose database uses
   `DB_PASS` as its root password; `COMPOSE_DB_PASSWORD` can set a separate app
   user password.
2. From the project root, run:

   ```sh
   docker compose up --build
   ```

3. Open <http://localhost:3000>. The API gateway is available on port `4000`;
   PHP controllers and MySQL stay on the internal Compose network.

The Compose database starts empty. Create a fresh account through the app; the
existing local database, users, and schedule demo rows are not copied. Database
contents persist in the `grindfm_database` volume when you stop the stack with
`docker compose down`. The MySQL initialization scripts run only when that volume
is first created.

Use `docker compose down -v` only when you intentionally want to erase the
Compose database and start over.
