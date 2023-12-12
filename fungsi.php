<?php

	include 'koneksi.php';

	function tambah_data($data, $files){

		$npm = $data['npm'];

        $split = explode('.',$files['foto_mahasiswa']['name']);
        $ekstensi = $split[count($split)-1];

        $foto_mahasiswa = $npm.'.'.$ekstensi;
        $nama_mahasiswa = $data['nama_mahasiswa'];
        $gender = $data['gender'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $alamat = $data['alamat'];

        $dir = "img/";
        $tmpFile = $files['foto_mahasiswa']['tmp_name'];

        move_uploaded_file($tmpFile, $dir.$foto_mahasiswa);

        $query = "INSERT INTO mahasiswa VALUES(null, '$npm', '$foto_mahasiswa', '$nama_mahasiswa', '$gender', '$tanggal_lahir', '$alamat', 000)";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        if ($sql) {
            // Trigger logic to add the last word of alamat to filter_kota
            $lastWord = getLastWord($alamat);
    
            $checkFilterQuery = "SELECT 1 FROM filter_kota WHERE nama_kota = '$lastWord'";
            $checkFilterResult = mysqli_query($GLOBALS['conn'], $checkFilterQuery);
    
            if (!$checkFilterResult || mysqli_num_rows($checkFilterResult) === 0) {
                // The last word is not in filter_kota, add it
                $insertFilterQuery = "INSERT INTO filter_kota (nama_kota) VALUES ('$lastWord')";
                mysqli_query($GLOBALS['conn'], $insertFilterQuery);
            }
    
            // Continue with the rest of your function logic...
    
            $triggerQuery = "INSERT INTO nilai_mahasiswa (npm, nama_mahasiswa, tugas, uts, uas, tugas_akhir) VALUES ('$npm', '$nama_mahasiswa', NULL, NULL, NULL, NULL)";
            $triggerSql = mysqli_query($GLOBALS['conn'], $triggerQuery);
    
            if ($triggerSql) {
                return true;
            } else {
                return "Error executing trigger: " . mysqli_error($GLOBALS['conn']);
            }
        } else {
            return "Error adding data to mahasiswa: " . mysqli_error($GLOBALS['conn']);
        }
    }

    
    function getLastWord($string) {
        $words = explode(' ', $string);
        return end($words);
    }

	function ubah_data($data,$files){
		$id_mahasiswa = $data['id_mahasiswa'];
        $npm = $data['npm'];
        $nama_mahasiswa = $data['nama_mahasiswa'];
        $gender = $data['gender'];
        $tanggal_lahir = $data['tanggal_lahir'];
        $alamat = $data['alamat'];

        $queryShow = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa';";
        $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);

        if ($files['foto_mahasiswa']['name'] == "") {
            $foto_mahasiswa = $result['foto_mahasiswa'];
        } else {
        	$split = explode('.',$files['foto_mahasiswa']['name']);
        	$ekstensi = $split[count($split)-1];
            $foto_mahasiswa = $result['npm'].'.'.$ekstensi;
            unlink("img/".$result['foto_mahasiswa']);
            move_uploaded_file($files['foto_mahasiswa']['tmp_name'], 'img/'.$foto_mahasiswa)
            ;
        }

        $query = "UPDATE mahasiswa SET npm='$npm', foto_mahasiswa='$foto_mahasiswa', nama_mahasiswa='$nama_mahasiswa', gender='$gender', tanggal_lahir='$tanggal_lahir', alamat='$alamat' WHERE id_mahasiswa ='$id_mahasiswa';";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        $updateNilaiQuery = "UPDATE nilai_mahasiswa SET nama_mahasiswa = '$nama_mahasiswa' WHERE npm = '$npm';";
        mysqli_query($GLOBALS['conn'], $updateNilaiQuery);

        return true;
	}

    function hapus_data($data) {
        $id_mahasiswa = $data['hapus'];
    
        // Retrieve the npm for the selected mahasiswa
        $queryNPM = "SELECT npm FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
        $sqlNPM = mysqli_query($GLOBALS['conn'], $queryNPM);
        $resultNPM = mysqli_fetch_assoc($sqlNPM);
        $npm = $resultNPM['npm'];
    
        // Delete data from nilai_mahasiswa
        $queryDeleteNilai = "DELETE FROM nilai_mahasiswa WHERE npm = '$npm'";
        $sqlDeleteNilai = mysqli_query($GLOBALS['conn'], $queryDeleteNilai);
    
        if (!$sqlDeleteNilai) {
            return "Error deleting data from nilai_mahasiswa: " . mysqli_error($GLOBALS['conn']);
        }
    
        // Retrieve data from mahasiswa
        $queryShow = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
        $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);
    
        // Delete mahasiswa data
        unlink("img/" . $result['foto_mahasiswa']);
        $queryDeleteMahasiswa = "DELETE FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
        $sqlDeleteMahasiswa = mysqli_query($GLOBALS['conn'], $queryDeleteMahasiswa);
    
        if (!$sqlDeleteMahasiswa) {
            return "Error deleting data from mahasiswa: " . mysqli_error($GLOBALS['conn']);
        }

        return true;
    }
    
    function ubah_nilai($data) {
        $id_nilai = $data['id_nilai'];
        $npm = $data['npm'];
        $nama_mahasiswa = $data['nama_mahasiswa'];
        $tugas = $data['tugas'];
        $uts = $data['uts'];
        $uas = $data['uas'];
        $tugas_akhir = $data['tugas_akhir'];
    
        $queryShow = "SELECT * FROM nilai_mahasiswa WHERE id_nilai = '$id_nilai';";
        $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
        $result = mysqli_fetch_assoc($sqlShow);
    
        $query = "UPDATE nilai_mahasiswa SET tugas='$tugas', uts='$uts', uas='$uas', tugas_akhir='$tugas_akhir' WHERE id_nilai ='$id_nilai';";
        $sql = mysqli_query($GLOBALS['conn'], $query);
        
        $triggerQuery = "UPDATE nilai_mahasiswa SET ipk = (tugas + uts + uas + tugas_akhir) / 100,
                        predikat = CASE
                            WHEN ipk >= 3.75 THEN 'A'
                            WHEN ipk >= 3.5 THEN 'A-'
                            WHEN ipk >= 3.25 THEN 'B+'
                            WHEN ipk >= 3.0 THEN 'B'
                            WHEN ipk >= 2.75 THEN 'B-'
                            WHEN ipk >= 2.5 THEN 'C+'
                            ELSE 'C'
                        END
                    WHERE id_nilai = '$id_nilai';";

        mysqli_query($GLOBALS['conn'], $triggerQuery);

        return true;
    }

?>
