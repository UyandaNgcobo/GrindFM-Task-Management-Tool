<?php

class ScheduleRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllSchedules(int $userId): array
    {
        $statement = $this->pdo->prepare(
            "SELECT schedule_id, title, description, starts_at, ends_at
            FROM Schedules
            WHERE user_id = ?
            ORDER BY starts_at ASC"
        );
        $statement->execute([$userId]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSchedule(
        int $userId,
        string $title,
        string $description,
        string $startsAt,
        ?string $endsAt
    ): bool {
        $statement = $this->pdo->prepare(
            "INSERT INTO Schedules (user_id, title, description, starts_at, ends_at)
            VALUES (?, ?, ?, ?, ?)"
        );

        try {
            return $statement->execute([$userId, $title, $description, $startsAt, $endsAt]);
        } catch (PDOException $error) {
            error_log($error->getMessage());
            return false;
        }
    }

    public function deleteSchedule(int $userId, int $scheduleId): bool
    {
        $statement = $this->pdo->prepare(
            "DELETE FROM Schedules
            WHERE user_id = ? AND schedule_id = ?"
        );

        try {
            return $statement->execute([$userId, $scheduleId]);
        } catch (PDOException $error) {
            error_log($error->getMessage());
            return false;
        }
    }
}
