<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $result = $conn->query(
        "SELECT * FROM tasks ORDER BY created_at DESC"
    );

    $tasks = [];

    while ($row = $result->fetch_assoc()) {
        $row["is_completed"] = (int) $row["is_completed"];
        $tasks[] = $row;
    }

    echo json_encode($tasks);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!is_array($input)) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON"]);
        exit;
    }

    $action = $input["action"] ?? "";

    if ($action === "create") {
        $title = trim($input["title"] ?? "");
        $description = trim($input["description"] ?? "");

        if ($title === "") {
            http_response_code(400);
            echo json_encode(["error" => "Task title is required"]);
            exit;
        }

        $stmt = $conn->prepare(
            "INSERT INTO tasks (title, description) VALUES (?, ?)"
        );
        $stmt->bind_param("ss", $title, $description);
        $stmt->execute();

        echo json_encode([
            "success" => true,
            "id" => $conn->insert_id
        ]);
        exit;
    }

    if ($action === "toggle") {
        $id = filter_var($input["id"] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid task ID"]);
            exit;
        }

        $stmt = $conn->prepare(
            "UPDATE tasks SET is_completed = 1 - is_completed WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["success" => true]);
        exit;
    }

    if ($action === "delete") {
        $id = filter_var($input["id"] ?? null, FILTER_VALIDATE_INT);

        if (!$id || $id < 1) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid task ID"]);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["success" => true]);
        exit;
    }

    http_response_code(400);
    echo json_encode(["error" => "Unknown action"]);
    exit;
}

http_response_code(405);
echo json_encode(["error" => "Method not allowed"]);
?>