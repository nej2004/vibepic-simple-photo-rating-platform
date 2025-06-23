document.addEventListener('DOMContentLoaded', function() {
    // Rating button selection
    document.querySelectorAll('.rating-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.parentNode.querySelectorAll('.rating-btn').forEach(b => {
                b.classList.remove('active');
            });
            this.classList.add('active');
        });
    });

    // Form submission
    document.querySelectorAll('.rating-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const photoId = this.dataset.photoId;
            const impression = this.querySelector('.rating-btn.active')?.dataset.impression;
            
            if (!impression) {
                alert('Please select an impression');
                return;
            }

            const submitBtn = this.querySelector('.submit-rating');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Submitting...';

            try {
                const response = await fetch('api/rate.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'photo_id': photoId,
                        'overall_impression': impression
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    alert('Rating submitted!');
                    window.location.reload();
                } else {
                    throw new Error(data.message || 'Rating failed');
                }
            } catch (error) {
                alert(error.message);
                submitBtn.disabled = false;
                submitBtn.textContent = 'Submit Rating';
            }
        });
    });
});