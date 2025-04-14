document.addEventListener('DOMContentLoaded', function() {
    const avatarInput = document.getElementById('avatarUpload');
    const avatarPreview = document.getElementById('avatarPreview');
    const widgetUserImage = document.querySelector('.widget-user-image');

    if (widgetUserImage) {
        // Click vào ảnh hoặc icon camera để mở dialog chọn file
        widgetUserImage.addEventListener('click', function() {
            avatarInput.click();
        });

        // Xử lý khi chọn file
        avatarInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const formData = new FormData();
                formData.append('image', this.files[0]);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                
                // Hiển thị loading state
                avatarPreview.style.opacity = '0.5';
                
                fetch('/profile/update-avatar', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật ảnh preview
                        avatarPreview.src = data.avatar_url;
                        // Hiển thị thông báo thành công
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.querySelector('.box-body').insertBefore(alertDiv, document.querySelector('.edit-profile-toggle'));
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    // Hiển thị thông báo lỗi
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        ${error.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    document.querySelector('.box-body').insertBefore(alertDiv, document.querySelector('.edit-profile-toggle'));
                })
                .finally(() => {
                    // Reset loading state
                    avatarPreview.style.opacity = '1';
                    // Reset input file để có thể chọn lại file giống nhau
                    avatarInput.value = '';
                });
            }
        });
    }
}); 