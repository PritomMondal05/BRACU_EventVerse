<?php
$page_title = "BRACU Eventverse | Club Dashboard";
include "../partials/header.php"; // header.php can access $page_title
session_start();
if($_SESSION['role']!=='club_admin'){
    header("Location: ../");
}
?>

<style>
    body {
      min-height: 100vh;
    }
    .sidebar {
      height: 100vh;
      background-color: #f8f9fa;
      box-shadow: 4px 0px 7px -7px; 
      border-radius: 10px;
    }
    .sidebar a {
      display: block;
      padding: 15px;
      color: #000;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #6C2BD9;
      color: white;
      border-radius: 10px;
    }
    h3{
        color: #6C2BD9;
        font-family: 'Inter', sans-serif;
    }
    .room-number-field {
        display: none;
    }
    .room-options {
        display: none;
    }
  </style>

<!-- Add Bootstrap Datepicker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <?php include("../partials/club_sidebar.php")?>

    <!-- Main content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2>Book Event 🎉</h2>
      <p>Organize a new fantastic event</p>

      <?php
include '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_details = $_POST['event_details'];
    $event_time_slot = $_POST['event_time_slot'];
    $event_booking_id = $_POST['event_booking_id'];
    $event_club_name = $_POST['event_club_name'];
    $event_club_email = $_POST['event_club_email'];
    $thumbnail = $_POST['thumbnail'];
    $room_type = $_POST['room_type'];
    $room_no = $room_type === 'room' ? $_POST['room_no'] : $_POST['room_type'];
    $event_type = $_POST['event_type'];

    // Check for time and room conflicts
    $sql_check = "SELECT * FROM events WHERE date = ? AND room_no = ? AND (
        (time_slot LIKE ? OR ? LIKE CONCAT('%', time_slot, '%'))
    )";
    $stmt_check = $conn->prepare($sql_check);
    $time_pattern = "%$event_time_slot%";
    $stmt_check->bind_param("ssss", $event_date, $room_no, $time_pattern, $event_time_slot);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo '
        <div class="alert alert-danger" role="alert">
            This room is already booked for the selected date and time slot. Please choose a different time or room.
        </div>
        ';
    } else {
        $sql3 = "SELECT * FROM clubs WHERE admin_id = '{$_SESSION['user_id']}' LIMIT 1";
        $result3 = mysqli_query($conn, $sql3);
        $club = mysqli_fetch_assoc($result3);

        // Insert into events table
        $sql = "INSERT INTO events (name, date, details, event_type, time_slot, booking_id, club_name, club_email, thumbnail, room_no, club_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssssi", $event_name, $event_date, $event_details, $event_type, $event_time_slot, 
                         $event_booking_id, $event_club_name, $event_club_email, $thumbnail, $room_no, $club['id']);
        $res = $stmt->execute();

        if ($res) {
            // get the event
            $event_id = $conn->insert_id;
            
            // create a budget for this event
            $sql4 = "INSERT INTO budget (event_id, booking_id) VALUES (?, ?)";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("is", $event_id, $event_booking_id);
            $res4 = $stmt4->execute();

            echo '
            <div class="alert alert-success" role="alert">
                Event added Successfully
            </div>
            ';
        } else {
            echo '
            <div class="alert alert-danger" role="alert">
                Something went wrong!
            </div>
            ';
        }
    }
}
?>

      <div class="card">
  <div class="card-body">
    <form method="POST" action="">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Event Name</label>
          <input type="text" class="form-control" name="event_name" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Event Date</label>
          <input type="text" class="form-control datepicker" name="event_date" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Event Details</label>
          <textarea type="text" class="form-control" name="event_details" required></textarea>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Event Type</label>
          <select class="form-select" name="event_type" required>
            <option value="technical">Technical</option>
            <option value="cultural">Cultural</option>
            <option value="academic">Academic</option>
            <option value="social">Social</option>
            <option value="sports">Sports</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Time Slot</label>
          <select class="form-select" name="event_time_slot" required>
            <option value="9:00 AM - 10:20 AM">9:00 AM - 10:20 AM</option>
            <option value="10:30 AM - 12:00 PM">10:30 AM - 12:00 PM</option>
            <option value="12:00 PM - 2:00 PM">12:00 PM - 2:00 PM</option>
            <option value="2:00 PM - 4:00 PM">2:00 PM - 4:00 PM</option>
            <option value="4:00 PM - 6:00 PM">4:00 PM - 6:00 PM</option>
          </select>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Room Type</label>
          <select class="form-select" name="room_type" id="roomType" required>
            <option value="">Select Room Type</option>
            <option value="auditorium">Auditorium</option>
            <option value="lecture_theatre">Lecture Theatre</option>
            <option value="room">Room</option>
            <option value="multipurpose_hall">Multipurpose Hall</option>
          </select>
        </div>

        <!-- Regular Room Numbers -->
        <div class="col-md-6 mb-3 room-number-field" id="roomNumberField">
          <label for="roomNo" class="form-label">Room Number</label>
          <select class="form-select" name="room_no" id="roomNo">
            <option value="">Select Room Number</option>
            <option value="UB21101">UB21101</option>
            <option value="UB21102">UB21102</option>
            <option value="UB21103">UB21103</option>
            <option value="UB21104">UB21104</option>
            <option value="UB21105">UB21105</option>
          </select>
        </div>

        <!-- Auditorium Options -->
        <div class="col-md-6 mb-3 room-options" id="auditoriumOptions">
          <label for="auditoriumNo" class="form-label">Auditorium</label>
          <select class="form-select" name="auditorium_no" id="auditoriumNo">
            <option value="">Select Auditorium</option>
            <option value="UB_Auditorium">UB Auditorium</option>
            <option value="Main_Auditorium">Main Auditorium</option>
          </select>
        </div>

        <!-- Lecture Theatre Options -->
        <div class="col-md-6 mb-3 room-options" id="lectureTheatreOptions">
          <label for="theatreNo" class="form-label">Lecture Theatre</label>
          <select class="form-select" name="theatre_no" id="theatreNo">
            <option value="">Select Lecture Theatre</option>
            <option value="LT01">LT01</option>
            <option value="LT02">LT02</option>
            <option value="LT03">LT03</option>
          </select>
        </div>

        <!-- Multipurpose Hall Options -->
        <div class="col-md-6 mb-3 room-options" id="hallOptions">
          <label for="hallNo" class="form-label">Multipurpose Hall</label>
          <select class="form-select" name="hall_no" id="hallNo">
            <option value="">Select Hall</option>
            <option value="MPH01">MPH01</option>
            <option value="MPH02">MPH02</option>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Booking ID</label>
          <input type="text" class="form-control" name="event_booking_id" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Club Name</label>
          <input type="text" class="form-control" name="event_club_name" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Club Email</label>
          <input type="email" class="form-control" name="event_club_email" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="input1" class="form-label">Thumbnail URL</label>
          <input type="text" class="form-control" name="thumbnail" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

    </div>
  </div>
</div>

<!-- Add Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
    // Initialize datepicker with dd/mm/yyyy format
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        startDate: 'today',
        autoclose: true
    });

    // Show/hide room options based on room type selection
    $('#roomType').change(function(){
        // Hide all room option fields first
        $('.room-options, .room-number-field').hide();
        $('.room-options select, #roomNo').prop('required', false);

        // Show the appropriate field based on selection
        switch($(this).val()) {
            case 'room':
                $('#roomNumberField').show();
                $('#roomNo').prop('required', true);
                break;
            case 'auditorium':
                $('#auditoriumOptions').show();
                $('#auditoriumNo').prop('required', true);
                break;
            case 'lecture_theatre':
                $('#lectureTheatreOptions').show();
                $('#theatreNo').prop('required', true);
                break;
            case 'multipurpose_hall':
                $('#hallOptions').show();
                $('#hallNo').prop('required', true);
                break;
        }
    });

    // Update the hidden room_no field when any room selection changes
    $('.room-options select, #roomNo').change(function() {
        $('input[name="room_no"]').val($(this).val());
    });
});
</script>

