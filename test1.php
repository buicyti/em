<!DOCTYPE HTML><html lang='vi'>
      <head><title>Setting ESP32</title></head><meta charset='UTF-8'/>
      <body>
      <style>
      body, html{width:100%;height:100%;display:flex;align-items:center;justify-content:center;}
      input[type=text],input[type=submit],input[type=password],select{width:100%;padding:14px 20px;margin:8px 0;border-radius:4px;}
      .main{border-radius:5px;background-color:#f2f2f2;margin:auto;padding:20px;max-width:320px;}
      input[type=text],input[type=password],select{display:inline-block;border:1px solid#ccc;box-sizing:border-box;}
      input[type=submit]{background-color:#4CAF50;color:white;border:none;cursor:pointer;}
      input[type=submit]:hover {background-color: #45a049;}
      input[type=number]{width:25%;padding:14px 20px;margin:8px 0;border-radius:4px;display:inline-block;border:1px solid#ccc;box-sizing:border-box;}
      
      </style>
      <div class='main'>
      <h2>CÀI ĐẶT ESP32</h2>
      <form method='POST' action=''>
      <p>Chọn chế độ kết nối với SERVER</p>
      <input type='radio' name='mang' value='WIFI' onchange='show1()' checked/>
      <label for='wifi'>WIFI</label><br>
      <input type='radio' name='mang' value='Ethernet' onchange='show2()'/>
      <label for='ethernet'>Ethernet</label><br/><br/><br/>
      <div id='wifi'><label for='ssid'>SSID: </label>
      <select name='ssid'></select>
      <label for='pass'>Mật khẩu: </label>
      <input type='password' name='pass' length=64><br/></div>
      <div id='ethernet' style='display: none;'>
            <label for='macc'>MAC: </label>
            <input type='text' name='macc' placeholder=''><br/>
            <label for='ipp'>IP: </label>
            <input type='text' name='ipp' placeholder=''><br/>
      </div>
      <label for='serverr'>Đường dẫn: </label>
      <input type='text' name='serverr' placeholder='http://172.26.11.93/EM/Arduino/post-data-nhietdo-doam-xuong.php' length=64><br/>
      <label for='linee'>LINE: </label>
      <input type='text' name='linee' placeholder='HS_SMD001'><br/>
      
      <!-- <label for='typee'>TYPE: </label>
      <select name='typee'>
      <option value='1'>Nhiệt độ - Độ ẩm Xưởng</option>
      <option value='2'>Nhiệt độ - Độ ẩm Tủ LKĐT</option>
      </select> -->

      <label for='sensor'>SENSOR: </label>
      <select name='sensor'>
      <option value='0'>SHT3x</option>
      <option value='1'>SHT4x</option>
      <option value='2'>SHT85</option>
      //<option value='3'>SHT71</option>
      <option value='4'>DHT22</option>
      </select>

      <p>SPEC: </p>
      Nhiệt độ:
      <input type='number' name='minTemp' value='18'>
       - 
      <input type='number' name='maxTemp' value='28'><br/>
      <span style="display:inline;width:100px;">Độ ẩm: </span>
      <input type='number' name='minHumi' value='18'>
       - 
       <input type='number' name='maxHumi' value='28'><br/>


      <input type='submit'>
      <script type='text/javascript'>
            function show1(){document.getElementById('ethernet').style.display = 'none';document.getElementById('wifi').style.display = 'block';}
            function show2(){document.getElementById('wifi').style.display = 'none';document.getElementById('ethernet').style.display = 'block';}
      </script>
      </form></div>

      <?php require_once 'core/init.php';
      if(isset($_POST['ahiiii'])) echo $_POST['ahiiii'];
      //echo $db->escape("ahiiiiii' OR 1=1 ;--");
      $unsafe_string = "<script>alert('XSS attack')</script>";

$safe_string = htmlspecialchars($unsafe_string);

echo $safe_string;

      ?>
      </body></html>