




<script>
// JavaScript function to start the clock
function startClock() {
    // Set the initial time from PHP
    let now = new Date(<?php echo time() * 1000; ?>); // PHP provides the current time in seconds, multiply by 1000 to convert to milliseconds for JavaScript

    // Function to update the clock every second
    function updateClock() {
        now.setSeconds(now.getSeconds() + 1); // Increment seconds by 1

        // Get the current date and time
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');
        let seconds = now.getSeconds().toString().padStart(2, '0');
        let ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // If hour is 0, set to 12

        // Get the month, day, and year
        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        let month = monthNames[now.getMonth()];
        let day = now.getDate();
        let year = now.getFullYear();

        // Format the date as Month Day, Year
        let formattedDate = `${month} ${day}, ${year}`;

        // Display the current time and date
        document.getElementById('clock').textContent = formattedDate + ' ' + hours + ':' + minutes + ':' + seconds + ' ' + ampm;
    }

    // Start the clock immediately
    updateClock();
    // Update the clock every 1000 milliseconds (1 second)
    setInterval(updateClock, 1000);
}

// Call the function to start the clock
startClock();
</script>




<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        $('#residentTable').DataTable();
    });
</script>

</div>
</body>
</html>