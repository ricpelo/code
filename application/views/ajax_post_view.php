<html>
    <head>
        <title>CodeIgniter ajax post</title>
        <?= link_tag('assets/css/style.css', 'stylesheet', 'text/css') ?>
        <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro|Open+Sans+Condensed:300|Raleway" rel="stylesheet" type="text/css">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript">
            // Ajax post
            $(document).ready(function() {
                $(".submit").click(function(event) {
                    event.preventDefault();
                    var user_name = $("input#name").val();
                    var password = $("input#pwd").val();
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url("ajax_post_controller/user_data_submit") ?>",
                        dataType: 'json',
                        data: {name: user_name, pwd: password},
                        success: function(res) {
                            if (res) {
                                // Show Entered Value
                                $("div#result").show();
                                $("div#value").html(res.username);
                                $("div#value_pwd").html(res.pwd);
                            }
                        }
                    });
                });
            });
        </script>
    </head>
    <body>
        <div class="main">
            <div id="content">
                <h2 id="form_head">Codelgniter Ajax Post</h2><br/>
                <hr>
                <div id="form_input">
                    <?= form_open() ?>
                    <?= form_label('User Name') ?>
                    <?= form_input(array(
                        'name' => 'name',
                        'class' => 'input_box',
                        'placeholder' => 'Please Enter Name',
                        'id' => 'name'
                    )) ?>
                    <br>
                    <br>
                    <?= form_label('Password') ?>
                    <?= form_input(array(
                        'type' => 'password',
                        'name' => 'pwd',
                        'class' => 'input_box',
                        'placeholder' => '',
                        'id' => 'pwd'
                    )) ?>
                </div>
                <div id="form_button">
                    <?= form_submit('submit', 'Submit', 'class="submit"') ?>
                </div>
                <?= form_close() ?>

                <div id="result" style="display: none">
                    <div id="content_result">
                        <h3 id="result_id">You have submitted these values</h3><br/><hr>
                        <div id="result_show">
                            <label class="label_output">Entered Name: <div id="value"></div></label>
                            <br>
                            <br>
                            <label class="label_output">Entered Password: <div id="value_pwd"></div></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
