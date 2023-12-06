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

        $query = "INSERT INTO mahasiswa VALUES(null, '$npm', '$foto_mahasiswa', '$nama_mahasiswa', '$gender', '$tanggal_lahir', '$alamat')";
        $sql = mysqli_query($GLOBALS['conn'], $query);

        return true;
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

        return true;
	}

	function hapus_data($data){

		$id_mahasiswa = $data['hapus'];
	    $queryShow = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
	    $sqlShow = mysqli_query($GLOBALS['conn'], $queryShow);
	    $result = mysqli_fetch_assoc($sqlShow);

	    //var_dump($sqlShow);
	    unlink("img/" . $result['foto_mahasiswa']);

	    $query = "DELETE FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa';";
	    $sql = mysqli_query($GLOBALS['conn'], $query);

	    return true;
	}
?>