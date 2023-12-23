
<?php include ('config/endpoint.php')?>

<input type="number" id="idphone" name="idphone" required>
<button type="button" onclick="deletePhone()">Delete</button>

<p id="successMessage" style="color: green; display: none;">Phone deleted successfully!</p>
<p id="errorMessage" style="color: red; display: none;">Error deleting phone data.</p>

<script>
    function deletePhone() {
        const apiUrl = '<?=$url_delete?>';
        const idphone = document.getElementById('idphone').value;

        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: idphone })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            document.getElementById('successMessage').style.display = 'block';
            document.getElementById('errorMessage').style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'block';
        });
    }
</script>

