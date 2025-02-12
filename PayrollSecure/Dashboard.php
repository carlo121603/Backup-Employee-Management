<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- <link rel="stylesheet" href="Style.css"> -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .main-content{
          padding-left: 200px;
        }
        .dashboard-widgets {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .widget {
            background: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 200px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .dashboard-table {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
  </style>
</head>
  <body>
      <?php 
        include 'Sidebar.php';
      ?>
      <div class="main-content" id="main-content">
        <h1>Dashboard Overview</h1>
          <div class="dashboard-widgets">
              <div class="widget bg-$green-300">
                  <h2>Total Users</h2>
                  <p>1,250</p>
              </div>
              <div class="widget">
                  <h2>Revenue</h2>
                  <p>$45,890</p>
              </div>
              <div class="widget">
                  <h2>New Orders</h2>
                  <p>320</p>
              </div>
              <div class="widget">
                  <h2>Pending Requests</h2>
                  <p>15</p>
              </div>
          </div>

          <div class="dashboard-table">
              <h2>Recent Transactions</h2>
              <table>
                  <tr>
                      <th>ID</th>
                      <th>User</th>
                      <th>Amount</th>
                      <th>Status</th>
                  </tr>
                  <tr>
                      <td>#1023</td>
                      <td>John Doe</td>
                      <td>$120</td>
                      <td>Completed</td>
                  </tr>
                  <tr>
                      <td>#1024</td>
                      <td>Jane Smith</td>
                      <td>$90</td>
                      <td>Pending</td>
                  </tr>
                  <tr>
                      <td>#1025</td>
                      <td>Mark Wilson</td>
                      <td>$230</td>
                      <td>Completed</td>
                  </tr>
              </table>
          </div>
      </div>
  </body>
</html>