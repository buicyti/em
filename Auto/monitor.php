<!DOCTYPE html>
<?php
// Require database & thông tin chung
@require_once($_SERVER['DOCUMENT_ROOT'] . '/EM/core/init.php');
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <base href="./">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chorme,Firefox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Design by Engineer Team">
    <meta name="author" content="Tư Đồ">
    <meta name="keyword" content="Thiết kế trên nền Bootstrap 5, Sidebar,...">
    <title>EM - Auto</title>
    <link rel="icon" href="<?php echo $_DOMAIN; ?>assets/images/favicon.ico" type="image/x-icon">
    <!-- Liên kết Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>assets/bootstrap/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/style.css">
    <!-- CSS Sidebar -->
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/simplebar.css" type="text/css" media="all" />
    <style>
        body {
            background-color: #000;
        }
        @font-face{
            src: url('00085-UTM-EdwardianKT.ttf');
            font-family:'EdwardianKT';
            font-weight: 1 1000;
        }
        .glitch {
            font-family: 'EdwardianKT';
            overflow: hidden;
            font-size: 72px;
            font-weight: 700;
            line-height: 2;
            color: #fff;
            letter-spacing: 5px;
            animation: shift 1s ease-in-out infinite alternate;
        }

        .glitch:before,
        .glitch:after {
            display: block;
            content: attr(data-glitch);
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.8;

        }

        .glitch:before {
            animation: glitch 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
            color: #8b00ff;
            z-index: -1;
        }

        .glitch:after {
            animation: glitch 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) reverse both infinite;
            color: #00e571;
            z-index: -2;
        }

        @keyframes glitch {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-3px, 3px);
            }

            40% {
                transform: translate(-3px, -3px);
            }

            60% {
                transform: translate(3px, 3px);
            }

            80% {
                transform: translate(3px, -3px);
            }

            to {
                transform: translate(0);
            }
        }

        @keyframes shift {

            0%,
            40%,
            44%,
            58%,
            61%,
            65%,
            69%,
            73%,
            100% {
                transform: skewX(0deg);
            }

            41% {
                transform: skewX(10deg);
            }

            42% {
                transform: skewX(-10deg);
            }

            59% {
                transform: skewX(40deg) skewY(10deg);
            }

            60% {
                transform: skewX(-40deg) skewY(-10deg);
            }

            63% {
                transform: skewX(10deg) skewY(-5deg);
            }

            70% {
                transform: skewX(-50deg) skewY(-20deg);
            }

            71% {
                transform: skewX(10deg) skewY(-10deg);
            }
        }

        ul {
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 50vw;
            max-width: 1000px;
            max-height: 40vh;
            list-style: none;
            color: #d6d6d6;
            overflow: scroll;
            overflow: -moz-scrollbars-none;
            -ms-overflow-style: none;
        }

        ul::-webkit-scrollbar {
            width: 0 !important;
            display: none;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center">
    <div data-glitch="Đừng tắt nhé..." class="glitch">Đừng tắt nhé...</div><!-- Enjoy my life...ENJOY MY LIFE -->
    <ul></ul>
</body>

</html>
<script type="text/javascript" src="../assets/jquery/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        reload10p();
        reload10s();
        //call reload
        setInterval(function() {
            reload10p()
        }, 10 * 60 * 1000); //10p
        setInterval(function() {
            reload10s()
        }, 10 * 1000); //10s

    });

    function reload10s() {
        callAjax("updateLOB", null)
    }

    function reload10p() {
        callAjax("insertLog", "Xưởng");
        callAjax("insertLog", "Tủ LKĐT");
        callAjax("delLog", "Xưởng");
        callAjax("delLog", "Tủ LKĐT");
    }

    function callAjax(action, vitri) {
        $.ajax({
            type: "POST",
            url: "../php/monitors-auto.php",
            data: {
                action: action,
                vitri: vitri
            },
            dataType: "text",
            success: function(response) {
                $('ul').prepend(response)
                $('ul').animate({
                    scrollTop: 0
                }, 500)
            },
            error: function(err) {
                console.error('Lỗi');
            }
        });
    }
</script>