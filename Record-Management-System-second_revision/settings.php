<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
   
    <?php include 'navbar.php'; ?>
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
    
      .settings-container {
        margin: 20px;
        background-color: #fff;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: calc(100% - 250px); 
        margin: 0 auto;
      }

      .settings-section {
        margin-bottom: 20px;
      }

      .settings-section h2 {
        border-bottom: 2px solid #4caf50;
        padding-bottom: 5px;
        margin-bottom: 15px;
        font-size: 1.5em;
      }

      .settings-item {
        margin-bottom: 10px;
      }

      .settings-item label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
      }

      .settings-item input[type="text"],
      .settings-item input[type="password"],
      .settings-item select {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
      }

      .settings-item input[type="checkbox"] {
        margin-right: 5px;
      }

      .settings-item button {
        padding: 10px 15px;
        background-color: #4caf50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .settings-item button:hover {
        background-color: #45a049;
      }


      /* @media (max-width: 768px) {
        .navbar {
          width: 100%;
          left: 0;
        }

        .sidebar {
          width: 100%;
          height: auto;
          position: relative;
          display: flex;
          flex-direction: row;
          overflow-x: auto;
        }

        .settings-container {
          width: 100%;
          margin-left: 0;
        }

        .sidebar a {
          flex: 1;
          text-align: center;
        }
      } */
    </style>
  </head>
  <body>
    <div class="burger-menu" id="burgerMenu">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
      </div>
  
      <div class="sidebar" id="sidebar">
        <h2>VNHS RMS</h2>
        <a href="Dashboard.php">Dashboard</a>
        <a href="http://localhost/proj3rec.management/student_record.php"
          >Student Records</a
        >
        <a href="http://localhost/proj3rec.management/view_teachers.php"
          >Teacher Records</a
        >
        <a href="settings.html">Settings</a>
        <a href="#logout" class="logout">Log out</a>
      </div>
  
      


    <div class="settings-container">
      <div class="settings-section">
        <h2>User Account Settings</h2>
        <div class="settings-item">
          <label for="profile-name">Profile Name:</label>
          <input type="text" id="profile-name" placeholder="Enter your name" />
        </div>
        <div class="settings-item">
          <label for="profile-email">Email:</label>
          <input
            type="text"
            id="profile-email"
            placeholder="Enter your email"
          />
        </div>
        <div class="settings-item">
          <label for="password">Change Password:</label>
          <input
            type="password"
            id="password"
            placeholder="Enter new password"
          />
        </div>
        <div class="settings-item">
          <label for="language">Language:</label>
          <select id="language">
            <option value="en">English</option>
            <option value="es">Spanish</option>
          </select>
        </div>
      </div>

      <div class="settings-section">
        <h2>Data Management Settings</h2>
        <div class="settings-item">
          <label for="backup">Backup & Restore:</label>
          <button>Schedule Backup</button>
        </div>
        <div class="settings-item">
          <label for="export">Export Data:</label>
          <select id="export">
            <option value="csv">CSV</option>
            <option value="excel">Excel</option>
            <option value="pdf">PDF</option>
          </select>
          <button>Export Now</button>
        </div>
      </div>

      <div class="settings-section">
        <h2>Security Settings</h2>
        <div class="settings-item">
          <label for="2fa">Two-Factor Authentication:</label>
          <input type="checkbox" id="2fa" /> Enable 2FA
        </div>
        <div class="settings-item">
          <label for="session-timeout">Session Timeout:</label>
          <select id="session-timeout">
            <option value="10min">10 Minutes</option>
            <option value="30min">30 Minutes</option>
            <option value="1hour">1 Hour</option>
          </select>
        </div>
      </div>

      <div class="settings-item">
        <button>Save Settings</button>
      </div>
    </div>

    <script src="burger_menu.js"></script>
  </body>
</html>
