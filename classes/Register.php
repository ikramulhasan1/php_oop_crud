<?php
include_once './lib/database.php';

class Register
{
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addRegister($data, $file)
    {
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['photo']['name'];
        $file_size = $file['photo']['size'];
        $file_temp = $file['photo']['tmp_name'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $upload_image = "upload/" . $unique_image;

        if (empty($name) || empty($email) || empty($phone) || empty($address) || empty($file_name)) {
            $msg = "Filds Must Not Be empty";
            return $msg;
        } elseif ($file_size > 1048567) {
            $msg = "File size must be less than 1MB";
            return $msg;
        } elseif (in_array($file_ext, $permited) == false) {
            $msg = "You Can upload only" . implode(', ', $permited);
            return $msg;
        } else {
            move_uploaded_file($file_temp, $upload_image);
            $query = "INSERT INTO `students` (`name`, `email`, `phone`,
            `photo`, `address`) VALUES ('$name', '$email', '$phone', '$upload_image', '$address')";

            $result = $this->db->insert($query);
            if ($result) {
                $msg = "Registration successful";
                return $msg;
            } else {
                $msg = "Registration failed";
                return $msg;
            }
        }
    }

    public function getAllStudents()
    {
        $query = "SELECT * FROM `students` ORDER BY id DESC";
        $result = $this->db->select($query);
        return $result;
    }

    public function getStdById($id)
    {
        $query = "SELECT * FROM `students` WHERE id = '$id'";
        $result = $this->db->select($query);
        return $result;
    }

    public function updateStudent($data, $file, $id)
    {
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $address = $data['address'];

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['photo']['name'];
        $file_size = $file['photo']['size'];
        $file_temp = $file['photo']['tmp_name'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
        $upload_image = "upload/" . $unique_image;

        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $msg = "Filds Must Not Be empty";
            return $msg;
        }
        if (!empty($file_name)) {
            if ($file_size > 1048567) {
                $msg = "File size must be less than 1MB";
                return $msg;
            } elseif (in_array($file_ext, $permited) == false) {
                $msg = "You Can upload only" . implode(', ', $permited);
                return $msg;
            } else {
                $img_query = "SELECT * FROM `students` WHERE id = '$id'";
                $img_res = $this->db->select($img_query);
                if ($img_res) {
                    while ($row = mysqli_fetch_assoc($img_res)) {
                        $photo = $row['photo'];
                        unlink($photo);
                    }
                }


                move_uploaded_file($file_temp, $upload_image);

                $query = "UPDATE `students` SET name='$name', email='$email',
                        phone='$phone', photo='$upload_image',
                        address='$address' WHERE id = '$id'";

                $result = $this->db->insert($query);
                if ($result) {
                    $msg = "Student update successful";
                    return $msg;
                } else {
                    $msg = "Update failed";
                    return $msg;
                }
            }
        } else {
            $query = "UPDATE `students` SET name='$name', email='$email',
                        phone='$phone', address='$address' WHERE id = '$id'";

            $result = $this->db->insert($query);
            if ($result) {
                $msg = "Student update successful";
                return $msg;
            } else {
                $msg = "Update failed";
                return $msg;
            }
        }
    }

    //Delete Student
    public function delStudent($id)
    {
        $img_query = "SELECT * FROM `students` WHERE id = '$id'";
        $img_res = $this->db->select($img_query);  // Assuming select() works as intended
        if ($img_res) {
            while ($row = mysqli_fetch_assoc($img_res)) {
                $photo = $row['photo'];
                if (file_exists($photo)) {
                    unlink($photo); 
                }
            }
        }

        $del_query = "DELETE FROM `students` WHERE id = '$id'";
        $result = $this->db->insert($del_query);  

        if ($result) {
            $msg = "Student deleted successfully";
            return $msg;
        } else {
            $msg = "Delete failed";
            return $msg;
        }
    }
}
