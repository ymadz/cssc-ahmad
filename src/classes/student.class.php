<?php
namespace Src\Classes;
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once("database.class.php");
use Src\Classes\Database;
use PDO;


class Student{

    protected $database;

    public function __construct(){
        $this->database = new Database();
    }


    public function calculateGWA() {
        $totalPoints = 0;
        $totalUnits = 0;

        for ($i = 0; $i < count($_SESSION['course-fields']['subject-code']); $i++) {
            $totalPoints += $_SESSION['course-fields']['grade'][$i] * $_SESSION['course-fields']['unit'][$i];
            $totalUnits += $_SESSION['course-fields']['unit'][$i];
        }

        $gwa = $totalUnits > 0 ? $totalPoints / $totalUnits : 0;
        $honorsMessage = $gwa <= 2.0 ? "Congratulations! You qualify for honors." : "You do not qualify for honors.";

        return ['gwa' => $gwa, 'honorsMessage' => $honorsMessage];
    }

    public function handleRequest() {
        session_start(); // Start the session

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_GET['action']) && $_GET['action'] === 'saveCourse') {
                $this->saveCourseToSession();
            } else {
                $this->calculateGPA();
            }
        } else {
            $this->showForm();
        }
    }

    private function showForm() {
        // Fetch courses from the session
        $courses = $_SESSION['courses'] ?? [];
        require_once '../resources/student/course_form.php';
    }

    private function saveCourseToSession() {
        // Validate and save course data to session
        $subjectCode = $_POST['subjectCode'];
        $units = $_POST['units'];
        $grades = $_POST['grades'];

        // Initialize session array if not set
        if (!isset($_SESSION['courses'])) {
            $_SESSION['courses'] = [];
        }

        $_SESSION['courses'][] = [
            'subjectCode' => $subjectCode,
            'units' => $units,
            'grades' => $grades
        ];
    }
}


?>


