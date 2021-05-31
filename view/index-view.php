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
            margin: 5px 3px
        }

        .statusToggle.profile {
            background: #149999;
            color: #ffffff;
            margin: 5px 0px
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

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="main-panel">
        <h1> دفترچه تلفن <span style="color:#007bec">کاربران</span></h1>
        <div class="box">
            <!---------- Header Box ---------->
            <a class="statusToggle" href="<?= BASE_URL ?>">🏠</a>
            <a id="addNewUser" class="statusToggle all" style="background: #0c8f10"> + افزودن مخاطب جدید</a>
            <a href="<?= site_url("?order=ASC") ?>" id="sortASC" class="statusToggle all" style="background: #007bec;">مرتب سازی براساس حروف الفبا </a>
            <a href="<?= site_url("?order=DESC") ?>" id="sortDESC" class="statusToggle"> مرتب سازی برخلاف حروف الفبا </a>


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
                        <input type="text" name='f-name' id="fName" placeholder="نام" required>
                        <input type="text" name='l-name' id="lName" placeholder="نام خانوادگی" required>
                        <input type="text" name='fa-name' id="faName" placeholder="نام پدر" required>
                        <input type="tel" name='phone_number' id="number" placeholder="+مثال:‌ 989123456789" pattern="{+}[0-9]{1,6}[0-9]{4,15}" required style="direction: ltr; width: 200px">

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
            </form>
        </div>



        <!---------- Users Data Box---------->
        <div class="box">
            <!---------- Users Data ---------->
            <table class="tabe-locations">
                <thead id="thead">
                    <tr>
                        <th id="fname-list" style="width:40%">نام</th>
                        <th id="lname-list" style="width:40%" class="text-center">نام خانوادگی</th>
                    </tr>
                    <!-- Users Added Here by Js -->
            </table>


            <!---------- Pagination ---------->
            <div id="pagination-space" class=pagination>

                <a href=" <?= site_url("?page=" . $_GET['page'] - 1) ?>" class="<?= $_GET['page'] == 1 ? 'pn-active' : 'pn' ?>"> &laquo; </a>
                <span id="innerpageNumbers"></span>
                <a href="<?= site_url("?page=" . $_GET['page'] + 1) ?>" class="<?= $_GET['page'] == $rows ? 'pn-active' : 'pn' ?>"> &raquo; </a>

            </div>

        </div>
    </div>

    <script src="<?= BASE_URL ?>view/assets/js/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        function getpageNum() {
            return <?= $_GET['page'] ?>;
        }


        function displayUsers(param) {
            var param = [param, getpageNum()];
            // alert(param[0]);
            $.ajax({
                url: "<?= BASE_URL . 'controller/get-process.php' ?>",
                method: 'POST',
                data: {
                    action: "get",
                    data: param,
                },
                success: function(response) {
                    // console.log(response);
                    response.forEach(function(user) {
                        createItems(user)
                    });
                }
            });
        }
        displayUsers();


        function createItems(user) {
            let parentTd = document.createElement('tr');

            let tdFirstName = document.createElement('td');

            let tdLastName = document.createElement('td');
            tdLastName.classList.add('text-center');


            let parenetBottonTDs = document.createElement('td');

            let showProfileBtn = document.createElement('button');
            showProfileBtn.innerHTML = 'مشاهده پروفایل';
            showProfileBtn.classList.add('statusToggle');
            showProfileBtn.classList.add('profile');
            showProfileBtn.classList.add('showUserProfile');
            showProfileBtn.setAttribute('user-id', user.id);

            let deleteBtn = document.createElement('button');
            deleteBtn.innerHTML = 'حذف';
            // deleteBtn.setAttribute('id', 'removeUserBtn');
            deleteBtn.classList.add('statusToggle');
            deleteBtn.classList.add('deleteUserProfile');
            deleteBtn.setAttribute('user-id', user.id);

            let thead = document.getElementById('thead');

            tdFirstName.innerHTML = user.first_name;
            tdLastName.innerHTML = user.last_name;
            parentTd.appendChild(tdFirstName);
            parentTd.appendChild(tdLastName);

            parenetBottonTDs.appendChild(showProfileBtn);
            parenetBottonTDs.appendChild(deleteBtn);

            showProfileBtn.onclick = showSelectedUser(user.id);
            deleteBtn.onclick = removeSelectedUser();

            parentTd.appendChild(parenetBottonTDs);

            thead.appendChild(parentTd);
        }

        function showSelectedUser(e) {
            // console.log(e);
        }

        function removeSelectedUser() {};


        // ---> Paginations Functions
        function paginationCounter() {
            $.ajax({
                url: "<?= BASE_URL . 'controller/pagination-process.php' ?>",
                method: 'POST',
                data: '',
                success: function(response) {
                    for (page = 1; page <= response; page++) {
                        createPagination(page);
                    };
                }
            });
        }
        paginationCounter();

        function createPagination(pages) {
            let PageNumberBtn = document.createElement('a');
            let pageLink = "http://localhost/7Learn.php/02-Project/phoneBook/?page=" + pages;

            PageNumberBtn.href = pageLink;
            PageNumberBtn.classList.add("pn");
            PageNumberBtn.innerHTML = pages;



            let pageNumberSpace = document.getElementById("innerpageNumbers");
            pageNumberSpace.appendChild(PageNumberBtn);
        }



        // -------------- Document Ready ---------------
        $(document).ready(function(event) {

            $('.showUserProfile').click(function(e) {
                alert("showUserProfile")
                $('#fName').val();
                $('.userInfoTab').slideToggle();

            });

            $('.deleteUserProfile').click(function(e) {
                alert("deleteUserProfile");
                // var user_id = $(this).attr('user-id');
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
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        displayUsers();
                        swal("مخاطب موردنظر با موفقیت افزوده شد", "", "success");
                        $('.userInfoTab').slideToggle();
                        $('#fName').val('');
                        $('#lName').val('');
                        $('#faName').val('');
                        $('#number').val('');
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

            $('#pagination-space').click(function() {
                // alert(getGetParam());
                // alert(pageNum);
                // e.preventDefault();
                displayUsers();
            });
        });
    </script>
</body>

</html>