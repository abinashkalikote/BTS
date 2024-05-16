<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banking Transaction Software</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        user-select: none;
    }

    .container{
        height: 100vh;
        width: 100vw;
        position: absolute;
        background-image: url('../../assets/images/dashboard_background2.png');
        background-size: cover;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: rgb(37, 152, 219);
        cursor: pointer;
    }

    .container1{
        height: 100vh;
        width: 100vw;
        position: absolute;
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: -7%;
    }

    .glass{
        height: 20%;
        width: 40%;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: rgb(15, 34, 88);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        box-shadow: 0 0 5px rgb(116, 113, 113);
    }

/* 

h1::before{
        content: 'Banking Transaction Software';
        position: absolute;
        height: 40px;
        width: 0px;
        display: block;
        border-right: 3px solid white;
        transition: all 0.5s;
        color: white;
        animation: showhide 5s linear infinite;
    }

    @keyframes showhide {
        0%{
            width: 0px;
        }50%{
            width: 420px;
        }100%{
            width: 0%;
        }
    } */
</style>
<body>
    <div class="container">
    </div>
    <div class="container1">
        <div class="glass">
            <h1>Banking Transaction Software</h1>
            <h3>Change Your Life...</h3>
        </div>
    </div>
</body>
</html>