<?php
include '../config/database.php';
session_start();

if ($_SESSION['role'] === 'super_admin' && isset($_GET['event_id']) && isset($_GET['status'])) {
    $event_id = $_GET['event_id'];
    $status = $_GET['status'];
    
    if ($status === 'deleted') {
        // First delete related records
        $sql_budget_items = "DELETE FROM budget_items WHERE event_id = ?";
        $stmt1 = $conn->prepare($sql_budget_items);
        $stmt1->bind_param("i", $event_id);
        $stmt1->execute();
        
        $sql_budget = "DELETE FROM budget WHERE event_id = ?";
        $stmt2 = $conn->prepare($sql_budget);
        $stmt2->bind_param("i", $event_id);
        $stmt2->execute();
        
        $sql_registrations = "DELETE FROM event_registrations WHERE event_id = ?";
        $stmt3 = $conn->prepare($sql_registrations);
        $stmt3->bind_param("i", $event_id);
        $stmt3->execute();
        
        // Finally delete the event
        $sql_event = "DELETE FROM events WHERE id = ?";
        $stmt4 = $conn->prepare($sql_event);
        $stmt4->bind_param("i", $event_id);
        $stmt4->execute();
        
        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
    } else {
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Update event status
            $sql_event = "UPDATE events SET status = ? WHERE id = ?";
            $stmt1 = $conn->prepare($sql_event);
            $stmt1->bind_param("si", $status, $event_id);
            $stmt1->execute();
            
            // Update budget status
            $sql_budget = "UPDATE budget SET status = ? WHERE event_id = ?";
            $stmt2 = $conn->prepare($sql_budget);
            $stmt2->bind_param("si", $status, $event_id);
            $stmt2->execute();
            
            // Commit transaction
            $conn->commit();
            
            $stmt1->close();
            $stmt2->close();
            
            $_SESSION['success_message'] = "Event status updated successfully!";
        } catch (Exception $e) {
            // Rollback on error
            $conn->rollback();
            $_SESSION['error_message'] = "Error updating event status: " . $e->getMessage();
        }
    }
    
    header("Location: ./");
} else {
    header("Location: ../");
}
?>