const Showcase = ()=>{
        document.addEventListener('set-thumbnail-active', function(event) {
        const primaryImage = document.querySelector('.showcase__img__primary img');
        const thumbnails = document.querySelectorAll('.showcase__img img');
            const clickedThumbnailId = event.detail[0]; // Assuming event.detail contains ID
            if (!clickedThumbnailId) {
              return;
            }
            const targetThumbnailId = `${clickedThumbnailId}-p-img`;
            const targetThumbnail = document.getElementById(targetThumbnailId);
            if (!targetThumbnail) {

              return;
            }
            // Assuming thumbnails is a NodeList of thumbnail elements
            thumbnails.forEach(thumbnail => {
              thumbnail.parentElement.classList.remove('active');
            })
            targetThumbnail.parentElement.classList.add('active');
            primaryImage.src = targetThumbnail.src;
          });

}

export default Showcase
