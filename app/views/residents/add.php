<!-- app/views/residents/add.php -->
<h1>Add Resident</h1>
<form action="index.php?action=store" method="POST">
    First Name: <input type="text" name="first_name" required><br>
    Last Name: <input type="text" name="last_name" required><br>
    Middle Name: <input type="text" name="middle_name"><br>
    Gender: 
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select><br>
    Address: <input type="text" name="address" required><br>
    <input type="submit" value="Add Resident">
</form>



<nav class="nav flex-column">
        <a class="nav-link" href="\barangaymanagement\app\views\admin\dashboard.php">
            <span class="icon">
                <i class="bi bi-grid"></i>
            </span>
            <span class="description">Dashboard</span>
        </a>
        <!-- menu with dropdown -->
        <a class="nav-link" href="" data-bs-toggle="collapse" data-bs-target="#submenu1" araia-expand="false" arai-controls="submenu">
            <span class="icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="description">Barangay Personnel Tool <i class="bi bi-caret-down-fill"></i></span>
         </a>
        <!-- submenu for clearance tool -->
         <div class="sub-menu collapse" id="submenu1">
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Barangay Officials</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Barangay Tanod</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">BNS</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">BHW</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Day Care Worker</span>
            </a>
         </div>
        <a class="nav-link" href="\barangaymanagement\app\views\residents\index.php">
            <span class="icon">
                <i class="bi bi-bell"></i>
            </span>
            <span clas="description">List of Residents</span>
        </a>

        <!-- menu with dropdown -->
         <a class="nav-link" href="" data-bs-toggle="collapse" data-bs-target="#submenu2" araia-expand="false" arai-controls="submenu">
            <span class="icon">
                <i class="bi bi-box-seam"></i>
            </span>
            <span class="description">Clearance & Cert. Tool <i class="bi bi-caret-down-fill"></i></span>
         </a>
        <!-- submenu for clearance tool -->
         <div class="sub-menu collapse" id="submenu2">
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Barangay Clearance</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Business Clearance</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Certificate of Residency</span>
            </a>
            <a class="nav-link" href="\barangaymanagement\app\views\BarangayClearance\barangayclearance_form.php">
                <span class="icon">
                    <i class="bi bi-file-earmark-check"></i>
                </span>
                <span class="description">Certificate of Indigency</span>
            </a>
         </div>
    </nav>