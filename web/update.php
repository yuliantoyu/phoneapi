<?php include ('config/endpoint.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            color: green; /* Warna sukses diubah ke hijau di sini */
        }
    </style>
</head>
<body>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : '';
$id = urlencode($id);
$apiUrl = $url_single_data.'?id=' . $id;
$jsonData = file_get_contents($apiUrl);
$data = json_decode($jsonData, true);

if ($data === null) {
    echo 'Gagal menguraikan JSON.';
} else {
    $explode = explode("/",$data['numberphone']);
    $numberphone = $explode[0];
    $provider = $explode[1];
    $id = $data['id'];
}
?>

<!-- Pesan sukses dipindahkan di atas formulir -->
<p id="successMessage" style="display: none;">Phone data updated successfully</p>
<br><br><bR>

<form>
    <input type="hidden" id="idphone" name="idphone" value=<?=$id?>>
    <label for="numberphone">Number Phone:</label>
    <input type="text" id="numberphone" name="numberphone" required value=<?=$numberphone?>>
    
    <label for="numberphone" required>Provider:</label>
    <select name="provider" id="provider" required>
    <option value="" <?php echo ($provider == '') ? 'selected' : ''; ?>>SELECT</option>
    <option value="Telkomsel" <?php echo ($provider == 'Telkomsel') ? 'selected' : ''; ?>>Telkomsel</option>
    <option value="XL" <?php echo ($provider == 'XL') ? 'selected' : ''; ?>>XL</option>

    </select>

    <button type="button" onclick="updateData()">Update</button>
</form>

<p id="errorMessage" style="color: red; display: none;">Error updating phone id data.</p>

<script>
     document.querySelector('form').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
    
    function updateData() {
        const apiUrl = '<?=$url_update?>';
        const formData = {
            id: document.getElementById('idphone').value,
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
