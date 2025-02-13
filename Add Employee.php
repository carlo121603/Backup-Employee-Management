<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Employee</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .red-text {
      color: red;
    }
  </style>
</head>
<body>

  <!-- Modal -->
  <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- Form Starts Here -->
        <form id="employeeForm" action="submit_employee.php" method="POST">
          <div class="modal-body">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs mb-3" id="employeeTabs" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab" aria-controls="personal" aria-selected="true">Personal Information</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="employment-tab" data-bs-toggle="tab" data-bs-target="#employment" type="button" role="tab" aria-controls="employment" aria-selected="false">Employment Details</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact Information</button>
              </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="employeeTabsContent">
              <!-- Personal Information Tab -->
              <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label for="firstName" class="form-label">First Name*</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="middleName" class="form-label">Middle Name</label>
                    <input type="text" class="form-control" id="middleName" name="middleName">
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="lastName" class="form-label">Last Name*</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                  </div>
                </div>
                
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="homeAddress" class="form-label">Home Address*</label>
                    <input type="text" class="form-control" id="homeAddress" name="homeAddress" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="zipCode" class="form-label">Zip Code</label>
                    <input type="text" class="form-control" id="zipCode" name="zipCode">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                      <label for="dob" class="form-label">Date of Birth* (dd/mm/yyyy)</label>
                      <input type="date" class="form-control" id="dob" name="dob" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="gender" class="form-label">Gender*</label>
                    <select class="form-select" id="gender" name="gender" required>
                      <option value="">Select Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="nationality" class="form-label">Nationality*</label>
                    <input type="text" class="form-control" id="nationality" name="nationality" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="maritalStatus" class="form-label">Marital Status*</label>
                    <select class="form-select" id="maritalStatus" name="maritalStatus" required>
                      <option value="">Select Marital Status</option>
                      <option value="single">Single</option>
                      <option value="married">Married</option>
                      <option value="divorced">Divorced</option>
                      <option value="widowed">Widowed</option>
                    </select>
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" onclick="nextTab('employment-tab')">Next</button>
                </div>
              </div>

              <!-- Employment Details Tab -->
              <div class="tab-pane fade" id="employment" role="tabpanel" aria-labelledby="employment-tab">
                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label for="position" class="form-label">Position*</label>
                    <select class="form-select" id="position" name="position" required>
                      <option value="">Select Position</option>
                      <option value="manager">Manager</option>
                      <option value="developer">Developer</option>
                      <option value="designer">Designer</option>
                    </select>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="employeeType" class="form-label">Employee Type*</label>
                    <select class="form-select" id="employeeType" name="employeeType" required>
                      <option value="">Select Employee Type</option>
                      <option value="full-time">Regular</option>
                      <option value="part-time">Probationary</option>
                      <option value="contract">Contractual</option>
                      <option value="full-time">Place Worker</option>
                      <option value="part-time">Project-Based</option>
                      <option value="part-time">Seasonal</option>
                    </select>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="bankAccount" class="form-label">Bank Account Number*</label>
                    <input type="text" class="form-control" id="bankAccount" name="bankAccount" required>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="pagibigNumber" class="form-label">Pag-IBIG Number</label>
                    <input type="text" class="form-control" id="pagibigNumber" name="pagibigNumber">
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="sssNumber" class="form-label">SSS Number*</label>
                    <input type="text" class="form-control" id="sssNumber" name="sssNumber" required>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="tinNumber" class="form-label">Tax Identification Number</label>
                    <input type="text" class="form-control" id="tinNumber" name="tinNumber">
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="philhealthNumber" class="form-label">Philhealth Number</label>
                    <input type="text" class="form-control" id="philhealthNumber" name="philhealthNumber">
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-4">
                    <label for="basicSalary" class="form-label">Basic Salary*</label>
                    <input type="number" class="form-control" id="basicSalary" name="basicSalary" required>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="allowances" class="form-label">Allowances*</label>
                    <input type="number" class="form-control" id="allowances" name="allowances" required>
                  </div>
                  <div class="mb-3 col-md-4">
                    <label for="payrollType" class="form-label">Payroll Type*</label>
                    <select class="form-select" id="payrollType" name="payrollType" required>
                      <option value="">Select Payroll Type</option>
                      <option value="monthly">Monthly</option>
                      <option value="bi-weekly">Daily</option>
                      <option value="weekly">Pieceworker</option>
                    </select>
                  </div>
                </div>

                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="department" class="form-label">Department*</label>
                    <select class="form-select" id="department" name="department" required>
                      <option value="">Select Department</option>
                      <option value="hr">HR</option>
                      <option value="it">IT</option>
                      <option value="finance">Finance</option>
                    </select>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="manager" class="form-label">Manager*</label>
                    <select class="form-select" id="manager" name="manager" required>
                      <option value="">Select Manager</option>
                      <option value="john">John Doe</option>
                      <option value="jane">Jane Doe</option>
                    </select>
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" onclick="prevTab('personal-tab')">Previous</button>
                  <button type="button" class="btn btn-primary" onclick="nextTab('contact-tab')">Next</button>
                </div>
              </div>

              <!-- Contact Information Tab -->
              <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                <div class="row">
                  <div class="mb-3 col-md-6">
                    <label for="contactNumber" class="form-label">Contact Number*</label>
                    <input type="text" class="form-control" id="contactNumber" name="contactNumber" required>
                  </div>
                  <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                </div>

                <div class="bg-light px-3">
                  <div class="mb-3 red-text pt-3 fs-5">
                    <label>Person to Contact in Case of Emergency</label>
                  </div>
                  <div class="mb-3">
                    <label for="emergencyName" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="emergencyName" name="emergencyName" required>
                  </div>
                  <div class="mb-3">
                    <label for="emergencyContact" class="form-label">Contact Number*</label>
                    <input type="text" class="form-control" id="emergencyContact" name="emergencyContact" required>
                  </div>
                  <div class="mb-3">
                    <label for="emergencyRelationship" class="form-label">Relationship to Employee*</label>
                    <input type="text" class="form-control" id="emergencyRelationship" name="emergencyRelationship" required>
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" onclick="prevTab('employment-tab')">Previous</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS and dependencies -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <script>
    function nextTab(tabId) {
      const nextTab = new bootstrap.Tab(document.getElementById(tabId));
      nextTab.show();
    }

    function prevTab(tabId) {
      const prevTab = new bootstrap.Tab(document.getElementById(tabId));
      prevTab.show();
    }
  </script>

  <!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  document.getElementById("employeeForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this); // Get form data

    fetch("submit_employee.php", {
      method: "POST",
      body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
      if (data.success) {
        Swal.fire({
          title: "Success!",
          text: "Employee added successfully!",
          icon: "success",
          confirmButtonText: "OK"
        }).then(() => {
          window.location.href = "http://localhost/PayrollSecure/Employee_Management.php"; // Refresh the page
        });
      } else {
        Swal.fire({
          title: "Error!",
          text: data.message || "Something went wrong!",
          icon: "error"
        });
      }
    })
    .catch(error => {
      Swal.fire({
        title: "Error!",
        text: "An error occurred while submitting the form!",
        icon: "error"
      });
      console.error("Error:", error);
    });
  });
</script>

  
</body>
</html>