<?php require('../../controllers/unauthorized.controller.php');?>
<?php require('../../constants/conn.constant.php');?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banking Transaction Software | Member</title>
    <link rel="stylesheet" href="../../assets/css/style.css" />
    <link rel="stylesheet" href="../../assets/plugins/datatable/datatable.min.css">
  </head>
  <body>
    <div class="container">
      <div class="top-header" style="text-align: left; padding-left: 6%">
        Member
        <div class="quick-button">
          <a href="./addMember/">Add Member</a>
          <a href="../statement/">View Statement</a>
        </div>
      </div>
      <Br />
      &nbsp;&nbsp;&nbsp;&nbsp;Available Member(s).
      <div>
      <!-- <button style="float: right;margin: 5px; cursor: pointer; padding: 10px;" onclick="Export2Word('memberlist');">Docx</button> -->
        <button id="print_excel" style="float: right;margin: 5px; cursor: pointer; padding: 10px;">Excel</button>
        <table border="1" id="memberlist" class="display" style="width:100%">
          <caption style="text-align: center;">
            <h3>Banking Transaction Software</h3>
          </caption>
          <thead>
            <tr>
              <th>S.N.</th>
              <th>Account No.</th>
              <th>Name</th>
              <th>Perm Address</th>
              <th>Temp Address</th>
              <th>Mobie No.</th>
              <th>Account Open Date</th>
              <th>Membership Date</th>
            </tr>
          </thead>
          <tbody>
            <!-- require showMembers.php to show all members -->
            <?php require('./showMembers.php'); ?>
          </tbody>
        </table>
      </div>
    </div>
  </body>
  <script src="../../assets/plugins/nepalidatepicker/jquery.min.js"></script>
  <script src="../../assets/plugins/datatable/datatable.min.js"></script>
  <script>
    $(document).ready(function () {
    $('#memberlist').DataTable({
    	"bLengthChange": false,
      "paging": false
  });
});
  </script>


<!-- To download excel file -->
  <script src="../../assets/plugins/tabletoexcel/jquery.table2excel.js"></script>
  <script>
    $("#print_excel").click(function(){
    $("#memberlist").table2excel({
      // exclude CSS class
      exclude: ".noExl",
      name: "Member List",
      filename: "Member List", //do not include extension
      fileext: ".xls" // file extension
    }); 
  });

  // to download document file
  function Export2Word(element, filename = ''){
    var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Member List</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+document.getElementById(element).innerHTML+postHtml;

    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });
    
    // Specify link url
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    
    // Specify file name
    filename = filename?filename+'.doc':'Memberlist.doc';
    
    // Create download link element
    var downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = url;
        
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
    
    document.body.removeChild(downloadLink);
}

  </script>
  <script src="../../assets/plugins/sweetalert/sweetalert.min.js"></script>
</html>
