<form action="process_comment.php" name="comment_form" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>Comments</legend>
        <div class="form-group">
            <label for="customer_name">Customer's name</label>
            <input type="text" class="form-control" name="customer_name" id="customer_name">
        </div>

        <div class="form-group">
            <label>Comment</label>
            <input type="text" class="form-control" name="comment_content" id="comment_content">
        </div>

        <div class="row">
            <div class="form-group col-6">
                <label>Enter Captcha</label>
                <input type="text" class="form-control" name="captcha" id="captcha">
            </div>
            <div class="form-group col-6">
                <label>Captcha Code</label>
                <img src="scripts/captcha.php" alt="PHP Captcha">
            </div>
        </div>
        <input type="hidden" name="product_id" value="<?= $row['id'] ?>" />
        <input type="submit" name="command" value="Post Comment" class="btn btn-dark btn-block">
    </fieldset>
</form>