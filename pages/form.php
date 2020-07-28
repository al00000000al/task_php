</div>
<hr/>
<div class="comment_form_wrap">
    <h2>Оставить комментарий</h2>
    <form method="post" class="comment_form">
        <label for="author">Ваше имя</label>
        <input type="text" name="author" id="author">
        <label for="comment">Ваш комментарий </label>
        <textarea id="comment" name="text" ></textarea>
        <input type="hidden" name="hash" value="<?= genCsrfTime('save_comment')?>">
        <input type="submit" id="send" value="Отправить">
    </form>
</div>
</main>