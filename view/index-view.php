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
            <a href="<?= site_url("?order=ASC") ?>" class="statusToggle all" style="background: #007bec;" href="<?= shapeSpace_add_var(current_site_url(), "order", "DESC") ?>">مرتب سازی براساس حروف الفبا </a>
            <a href="<?= site_url("?order=DESC") ?>" class="statusToggle" href="<?= shapeSpace_add_var(current_site_url(), "order", "ASC") ?>"> مرتب سازی برخلاف حروف الفبا </a>

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

                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td><?= $user->first_name ?></td>
                            <td class="text-center"><?= $user->last_name ?></td>
                            <td>
                                <button id="showUserInfo" class="statusToggle profile" user-id=<?= $user->id ?> style="margin : 5px 0px">مشاهده پروفایل</button>
                                <button class="statusToggle" id="remove-user" user-name="<?= $user->first_name . " " . $user->last_name ?>" user-id=<?= $user->id ?> style="margin : 5px 0px"> حذف </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
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
        $(document).ready(function() {

            $('#addNewUser').click(function(e) {
                $('.userInfoTab').slideToggle();
            });


            $('#showUserInfo').click(function() {
                $('.modal-overlay').fadeIn();
                var First_Name = $('#fname-list');
                var Last_Name = $('#lname-list');

                $('input#f-name').val(First_Name);
                $('input#l-name').val(Last_Name);
                // $('input#fa-name');
            });


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
                                swal("مخاطب موردنظر با موفقیت حذف شد", "", "success");
                                // var loadUrl = 'http://localhost/7Learn.php/02-Project/phoneBook/';
                                // $('.swal-button--confirm').click(function(e){
                                //     $(".tabe-locations").html().load(window);
                                // });
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

            $('input#cancelClose').click(function(e) {
                $('.userInfoTab').slideToggle();
            });


            $('form#addUserForm').submit(function() {
                e.preventDefault();
                var form = $(this);
                var resultTag = form.find('.ajax-result');
                $.ajax({
                    url: form.attr('action'),
                    method: {
                        action : "add",
                        data: form.attr('method')
                    },
                    data: form.serialize(),
                    success: function(response) {
                        resultTag.html(response);
                    }
                });
            });

        });
    </script>
</body>

</html>