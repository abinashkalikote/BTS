<?php

    $q = "SELECT * FROM fin_accounts ORDER BY `name`";
    $result = $conn->query($q); $sn = 1;
    if($result->num_rows > 0){ while($row = $result->fetch_assoc()){ ?>

    <tr>
        <td><?php echo $sn; ?></td>
        <td><a href="../statement/?accid=<?php echo $row['account_No'];?>"><?php echo "BTS2022".$row['account_No'];?></td>
        <td><?php echo $row['name'];?></td>
        <td><?php echo $row['permanent_Address'];?></td>
        <td><?php echo $row['temporary_Address'];?></td>
        <td><?php echo $row['mobile_No'];?></td>
        <td><?php echo $row['dob'];?></td>
        <td><?php echo $row['membership_Date'];?></td>
    </tr>

    <?php
    $sn++;
            }
        }
    
    ?>