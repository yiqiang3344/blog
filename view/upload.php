<h2>上传文件</h2>
<div>
    <form action="/upload?k=<?= $this->key ?>" method="post" enctype="multipart/form-data">
        <div>
            <label for="category">类型</label>
            <input class="input" type="text" name="category" id="category">
        </div>
        <div>
            <input class="input" type="file" name="file" id="file">
        </div>
        <div>
            <input type="submit" value="提交">
        </div>
    </form>
</div>