<?php include ('config/endpoint.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #successMessage, #errorMessage {
            margin-top: 10px;
            font-weight: bold;
            text-align: center;
        }

        #successMessage {
            color: green;
        }

        #errorMessage {
            color: red;
        }
    </style>
</head>
<body>

<form id="phoneForm">
    <label for="numberphone">No Handphone:</label>
    <input type="text" id="numberphone" name="numberphone" required>

    <label for="numberphone" required>Provider:</label>
    <select name="provider" id="provider" required>
        <option value="">SELECT</option>
        <option value="Telkomsel">Telkomsel</option>
        <option value="XL">XL</option>
    </select>
    <br>
    

    <button type="button" onclick="sendData()">Save</button>
</form>

<p id="successMessage" style="color: green; display: none;">Data sent successfully!</p>
<p id="errorMessage" style="color: red; display: none;">Error sending data.</p>

<script>

document.querySelector('form').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });

    
    function sendData() {
        const apiUrl = '<?=$url_create?>';
        const formData = {
            numberphone: document.getElementById('numberphone').value,
            provider: document.getElementById('provider').value
        };

        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
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
            document.getElementById('phoneForm').style.display = 'none'; // Hide the form

            
            setTimeout(() => {
                window.location.href = 'output.php';
            }, 2000);
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('successMessage').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'block';
        });
    }
</script>

</body>
</html>
