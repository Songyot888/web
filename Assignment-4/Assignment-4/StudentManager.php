<?php
class StudentManager {
    public function __construct() {
        session_start();
        if (!isset($_SESSION['students'])) {
            $_SESSION['students'] = [];
        }
    }

    public function addStudent($data) {
        $_SESSION['students'][] = $data;
    }

    public function getStudents() {
        return $_SESSION['students'];
    }

    public function deleteStudent($index) {
        if (isset($_SESSION['students'][$index])) {
            unset($_SESSION['students'][$index]);
            $_SESSION['students'] = array_values($_SESSION['students']); // รีเซ็ตคีย์ของอาร์เรย์
        }
    }

    public function editStudent($index, $data) {
        if (isset($_SESSION['students'][$index])) {
            $_SESSION['students'][$index] = $data;
        }
    }

    public function getStudent($index) {
        return $_SESSION['students'][$index] ?? null;
    }
}
?>