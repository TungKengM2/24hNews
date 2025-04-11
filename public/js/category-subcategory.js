/**
 * JavaScript để xử lý danh mục cha và danh mục con
 */
$(document).ready(function() {
    // Xử lý khi thay đổi danh mục cha
    $('#category_id').change(function() {
        var categoryId = $(this).val();
        if (categoryId) {
            // Gọi AJAX để lấy danh sách danh mục con
            $.ajax({
                url: '/admin/ajax/subcategories',
                type: 'GET',
                data: {
                    parent_id: categoryId
                },
                success: function(response) {
                    if (response.success) {
                        // Xóa tất cả các option hiện tại (trừ option đầu tiên)
                        $('#subcategory_id').find('option:not(:first)').remove();
                        
                        // Thêm các option mới
                        $.each(response.data, function(key, value) {
                            $('#subcategory_id').append('<option value="' + value.category_id + '">' + value.name + '</option>');
                        });
                        
                        // Hiển thị dropdown danh mục con
                        $('#subcategory_div').show();
                    } else {
                        // Ẩn dropdown danh mục con nếu không có danh mục con
                        $('#subcategory_div').hide();
                    }
                },
                error: function() {
                    console.error('Lỗi khi lấy danh sách danh mục con');
                    $('#subcategory_div').hide();
                }
            });
        } else {
            // Nếu không chọn danh mục cha, ẩn dropdown danh mục con
            $('#subcategory_div').hide();
            $('#subcategory_id').find('option:not(:first)').remove();
        }
    });
});
