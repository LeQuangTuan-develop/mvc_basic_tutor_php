<div class="container">
    <h3 class="mt-4 mb-3">Danh sách sản phẩm</h3>
    <table class="table table-success table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Mã sản phẩm</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Đơn giá</th>
                <th scope="col">Xử lý</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product):?>
            <tr>
                <th scope="row"><input type="checkbox" name="" id=""></th>
                <td><?php {{echo $product['masp'];}}?></td>
                <td><?php {{echo $product['tensp'];}}?></td>
                <td><?php {{echo $product['soluong'];}}?></td>
                <td><?php {{echo $product['dongia'];}}?></td>
                <td>
                    <a href="<?= BASE_URL?>/product/edit_product/1" class="btn btn-primary">Sửa</a>
                    <a href="<?= BASE_URL?>/product/delete_product/1" class="btn btn-danger">Xóa</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>