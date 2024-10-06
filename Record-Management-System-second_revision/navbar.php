<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <link rel="stylesheet" href="sidebar-navbar.css">
    <style>
        body {
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            margin: 0; 
            padding: 0; 
        }

        nav {
            background-color: darkolivegreen; 
            display: flex; 
            align-items: center; 
            padding: 15px 20px; 
            position: relative; 
        }

        .navbar img {
            height: 50px;
            margin-right: 20px; 
        }

        .nav-links {
            display: flex; 
            gap: 20px; 
        }

        .nav-links a {
            color: white; 
            text-decoration: none; 
            transition: color 0.3s; 
            position: relative; 
        }

        .nav-links a:hover {
            color: #e9ecef;
        }

        
        .dropdown {
            display: none; 
            position: absolute; 
            top: 60px;
            right: 230px; 
            background-color: #fff;
            width: 200px; 
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2); 
            z-index: 1; 
            border-radius: 5px; 
            overflow: hidden; 
            transition: opacity 0.3s ease, visibility 0.3s ease; 
        }

        .dropdown-content {
            display: flex;
            flex-direction: column; 
            background-color: #fff; 
            padding: 10px; 
            border-radius: 5px; 
        }

        .dropdown-content p {
            margin: 0; 
            cursor: pointer; 
            padding: 10px; 
            transition: background-color 0.3s; 
            color: darkolivegreen; 
        }

        .dropdown-content p:hover {
            background-color: darkolivegreen; 
            color: #fff; 
        }
    </style>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById("class-management-dropdown");
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block"; 
            dropdown.style.opacity = dropdown.style.display === "block" ? "1" : "0"; 
            dropdown.style.visibility = dropdown.style.display === "block" ? "visible" : "hidden"; 
        }

        function navigateTo(url) {
            window.location.href = url;
        }

        
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById("class-management-dropdown");
            const classManagementLink = document.querySelector('.nav-links a[onclick="toggleDropdown()"]');
            if (!event.target.closest('.nav-links a') && dropdown.style.display === "block") {
                dropdown.style.display = "none"; 
                dropdown.style.opacity = "0"; 
                dropdown.style.visibility = "hidden"; 
            }
        });
    </script>
</head>
<body>
<nav class="navbar">
    <img src="/Record-Management-System-second_revision/vega national high school.png" alt="Vega National High School Logo" class="logo" />
    <div class="nav-links">
        <a href="/Record-Management-System-second_revision/Dashboard.php">Dashboard</a>
        <a href="/Record-Management-System-second_revision/student_record.php">Student Records</a>
        <a href="/Record-Management-System-second_revision/view_teachers.php">Teacher Records</a>
        
       
        <a href="javascript:void(0);" onclick="toggleDropdown()">Class Management</a>
        <div id="class-management-dropdown" class="dropdown">
            <div class="dropdown-content">
                <p onclick="navigateTo('/Record-Management-System-second_revision/class_management/add_class.php')">Create Class</p>
                <p onclick="navigateTo('/Record-Management-System-second_revision/class_management/assign_student_form.php')">Assign Student</p>
                <p onclick="navigateTo('/Record-Management-System-second_revision/class_management/view_students_in_class.php')">View Classes</p>
             
            </div>
        </div>

        <a href="/Record-Management-System-second_revision/settings.php">Settings</a>
        <a href="/Record-Management-System-second_revision/#logout" class="logout">Log out</a>
    </div>
</nav> 
</body>
</html>
