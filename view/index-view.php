<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لیست مخاطبین</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>view/assets/css/style.css" />

    <style>
        body {
            background: #f2f2f2;
        }

        a {
            text-decoration: none;
        }

        h1 {
            text-align: center;
        }

        .main-panel {
            width: 1000px;
            margin: 30px auto;
        }

        .box {
            background: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 3px 3px #EEE;
            margin-bottom: 20px;
        }

        table.tabe-locations {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .statusToggle {
            background: #eee;
            color: #686868;
            border: 0;
            min-width: 70px;
            text-align: center;
            padding: 3px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 400;
            font-family: sahel;
            display: inline-block;
            margin: 0 3px;
        }

        .statusToggle.profile {
            background: #149999;
            color: #ffffff;
        }

        .statusToggle.all {
            background: #149999;
            color: #ffffff;
        }

        .statusToggle:hover,
        button.preview:hover {
            opacity: 0.7;
        }

        button.preview {
            padding: 0 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }

        tr {
            line-height: 36px;
        }

        tr:nth-child(2n) {
            background: #f7f7f7;
        }

        td {
            padding: 0 5px;
        }

        iframe#mapWivdow {
            width: 100%;
            height: 500px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="main-panel">
        <h1> دفترچه تلفن <span style="color:#007bec">کاربران</span></h1>
        <div class="box">
            <a class="statusToggle" href="<?= BASE_URL ?>">🏠</a>
            <a id="addNewUser" class="statusToggle all" style="background: #0c8f10"> + افزودن مخاطب جدید</a>

            <a href="<?= site_url("?order=ASC") ?>" id="sortASC" class="statusToggle all" style="background: #007bec;">مرتب سازی براساس حروف الفبا </a>
            <!-- href="<?= shapeSpace_add_var(current_site_url(), "order", "DESC") ?>" -->

            <a href="<?= site_url("?order=DESC") ?>" id="sortDESC" class="statusToggle"> مرتب سازی برخلاف حروف الفبا </a>
            <!-- href="<?= shapeSpace_add_var(current_site_url(), "order", "ASC") ?>" -->

            <!---------- Search Box ---------->
            <div class="search-box-total">
                <input type="text" class="search-box" id="search" placeholder="جستجوی مخاطب ..." autocomplete="none">
                <div class="clear"></div>
                <div class="search-results" style="display : none"></div>
            </div>

        </div>

        <!---------- slideDown Tab For Adding User ---------->
        <div class="userInfoTab">
            <form id='addUserForm' action="<?= site_url("controller/add-process.php") ?>" method="post">
                <div class="field-row">
                    <div class="field-content">
                        <input type="text" name='f-name' id="fName" placeholder="نام">
                        <input type="text" name='l-name' id="lName" placeholder="نام خانوادگی">
                        <input type="text" name='fa-name' id="faName" placeholder="نام پدر">
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-content">
                        <input type="submit" id="submit" value=" ثبت ">
                        <input type="cancel" id="cancelClose" readonly value="انصراف">
                    </div>
                </div>

                <div class=numbersSection>

                </div>

                <div class="ajax-result"></div>

            </form>
        </div>



        <!---------- User listing Box ---------->
        <div class="box">
            <table class="tabe-locations">
                <thead>
                    <tr>
                        <th id="fname-list" style="width:40%">نام</th>
                        <th id="lname-list" style="width:40%" class="text-center">نام خانوادگی</th>
                    </tr>
                    <tr>
                        <td id="showUserFName"></td>
                        <td id="showUserLName" class='text-center'></td>
                        <td>
                            <button id='showUserInfo' class='statusToggle profile' style='margin : 5px 0px'>مشاهده پروفایل</button>
                            <button class='statusToggle' id='remove-user' style='margin : 5px 0px'> حذف </button>
                        </td>
                    </tr>
                <tbody id="tbody"></tbody>
            </table>


            <!---------- Pagination ---------->
            <div class=pagination>
                <a href="<?= shapeSpace_add_var(current_site_url(), 'page', $_GET['page'] - 1) ?>" class="<?= $_GET['page'] == 1 ? 'pn-active' : 'pn' ?>"> &laquo; </a>

                <?php for ($i = 1; $i <= $rows; $i++) : ?>
                    <a class=" <?= $_GET['page'] == $i ? 'pn-active' : 'pn' ?> " href="<?= shapeSpace_add_var(current_site_url(), 'page', $i) ?>"> <?= $i ?> </a>
                <?php endfor; ?>

                <a href="<?= shapeSpace_add_var(current_site_url(), 'page', $_GET['page'] + 1) ?>" class="<?= $_GET['page'] == $rows ? 'pn-active' : 'pn' ?>"> &raquo; </a>
            </div>

        </div>
    </div>

    <script src="<?= BASE_URL ?>view/assets/js/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        function displayUsers(param) {
            var param = param;
            $.ajax({
                url: "<?= BASE_URL . 'controller/get-process.php' ?>",
                method: 'POST',
                data: {
                    action: "get",
                    data: param
                },
                success: function(response) {
                    response.forEach(function(user){
                        // console.log(user.id);
                        document.getElementById("showUserFName").innerHTML = user.first_name;
                        document.getElementById("showUserLName").innerHTML = user.last_name;
                        document.getElementById("showUserInfo").setAttribute("user-id", user.id);
                        document.getElementById("remove-user").setAttribute("user-name", user.first_name + " "+ user.last_name);
                        document.getElementById("remove-user").setAttribute("user-id", user.id);
                    });
                    
                }
            });
        }
        displayUsers();


        $(document).ready(function() {




            // $('#showUserInfo').click(function() {
            //     $('.modal-overlay').fadeIn();
            //     var First_Name = $('#fname-list');
            //     var Last_Name = $('#lname-list');

            //     $('input#f-name').val(First_Name);
            //     $('input#l-name').val(Last_Name);
            // });


            $('#remove-user').click(function(e) {
                var user_id = $(this).attr('user-id');
                var user_name = $(this).attr('user-name');
                swal('آیا از حذف «' + user_name + '» از لیست مخاطبین مطمئن هستید!؟', "با تأئید شما، مخاطب بلافاصله حذف میگردد", "warning");
                $('.swal-button--confirm').click(function(e) {
                    $.ajax({
                        url: "<?= BASE_URL . 'controller/remove-process.php' ?>",
                        method: 'POST',
                        data: {
                            action: 'remove',
                            userID: user_id
                        },
                        success: function(response) {
                            if (response) {
                                displayUsers();
                                swal("مخاطب موردنظر با موفقیت حذف شد", "", "success");
                            }
                        }
                    });
                });
            });


            $('input#search').keyup(function(e) {
                var input = $(this);
                var searchResult = $('.search-results');
                searchResult.html('در حال جستجو ...');

                $.ajax({
                    url: "<?= BASE_URL . 'controller/search-process.php' ?>",
                    method: 'POST',
                    data: {
                        action: 'search',
                        keyword: input.val()
                    },
                    success: function(response) {
                        searchResult.slideDown().html(response);
                    }
                });
            });


            $('#addNewUser').click(function() {
                $('.userInfoTab').slideToggle();
            });


            $('input#cancelClose').click(function(e) {
                $('.userInfoTab').slideToggle();
            });


            $('form#addUserForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var resultTag = form.find('.ajax-result');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        displayUsers();
                        swal("مخاطب موردنظر با موفقیت افزوده شد", "", "success");
                        $('.userInfoTab').slideToggle();
                    }
                });
            });

            $('#sortDESC').click(function(e) {
                e.preventDefault();
                displayUsers("DESC");
            });
            $('#sortASC').click(function(e) {
                e.preventDefault();
                displayUsers("ASC");
            });

        });
    </script>
</body>

</html>