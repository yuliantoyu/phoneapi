<?php include ('config/endpoint.php')?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
            background-color: #f4f4f4;
        }

        #addText {
            margin-top: 20px;
        }

        table {
            width: 500px;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        button {
            
            
            color: #000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #d6341a;
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

<div id="addText"><a href="input.php">Add</a></div>

<?php
$url = $url_read;

// Mengambil data JSON dari URL
$jsonData = @file_get_contents($url);

if ($jsonData === false) {
    // Gagal mengambil data, handle kesalahan di sini
    echo '<p style="color: red;">Data Not Found</p>';
    exit;
}

// Menguraikan JSON menjadi array PHP
$data = json_decode($jsonData, true);

// Cek apakah penguraian berhasil
if ($data === null) {
    echo 'Gagal menguraikan JSON.';
    exit;
} else {
    // Tampilkan atau gunakan data hasil penguraian
    ?>

    <table>
        <tr>
            <th>Id</th>
            <th>Ganjil</th>
			<th>Genap</th>
            <th colspan=2>Action</th>
        </tr>
        <?php
        foreach ($data['body'] as $item) { 
			$phone = explode("/",$item['numberphone']);
			?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td>
					<?php if( $phone[0]% 2 == 1) {?>
					<?= $phone[0] ?><br>
					<?=$phone[1]?>
					<?php } ?>

			</td>
				<td>
				<?php if( $phone[0]% 2 == 0) {?>
				<?= $phone[0] ?><br>
				<?=$phone[1]?>
				<?php } ?>

				</td>
                <td width=60px>

				<a class="idphone" href="update.php?id=<?= $item['id'] ?>">Edit</a>
					</td>
                <td width=60px>

				<input type="hidden" class="idphone" name="idphone" required value=<?= $item['id'] ?>>
                    <button type="button" onclick="deletePhone(this)">Delete</button>
                </td>
            </tr>
        <?php } ?>
    </table>

<?php } ?>

<p id="successMessage" style="color: green; display: none;">Phone deleted successfully!</p>
<p id="errorMessage" style="color: red; display: none;">Error deleting phone data.</p>

<script>
    function deletePhone(button) {
        const apiUrl = '<?=$url_delete ?>';
        const idphone = button.parentNode.querySelector('.idphone').value;

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
            // Optional: Remove the row from the table upon successful deletion
            const row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
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
