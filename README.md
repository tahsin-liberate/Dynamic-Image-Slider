**Description:**
This code creates a dynamic image slider with an associated image list that allows you to reorder the images in real-time. The slider automatically transitions between images every 3 seconds and provides a user-friendly interface for changing the order of images.

**Code Documentation:**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags and title -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider with Image List</title>

    <!-- CSS styles for styling the slider and image list -->
    <style>
        .slider-container {
            width: 400px;
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .slider-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease-in-out;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .order-control {
            width: 80px;
        }
    </style>
</head>
<body>
    <!-- Slider container -->
    <div class="slider-container">
        <img class="slider-image" id="sliderImage" src="" alt="Slider Image">
    </div>

    <!-- Image List -->
    <h2>Image List</h2>
    <table>
        <thead>
            <tr>
                <th>Index</th>
                <th>Image</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody id="imageList">
        </tbody>
    </table>

    <!-- JavaScript code -->
    <script>
        // Array of image URLs
        const imageUrls = [
            // Add your image URLs here
        ];

        const sliderImage = document.getElementById('sliderImage');
        const imageList = document.getElementById('imageList');
        let currentIndex = 0;

        // Function to change the image
        function changeImage() {
            sliderImage.src = imageUrls[currentIndex];
            currentIndex = (currentIndex + 1) % imageUrls.length; // Loop through images
        }

        // Function to populate the image list table
        function populateImageList() {
            // Clears existing content
            imageList.innerHTML = '';
            
            // Iterates through image URLs
            imageUrls.forEach((imageUrl, index) => {
                // Creates a new table row
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index}</td>
                    <td><img src="${imageUrl}" alt="Image ${index}" width="50"></td>
                    <td>
                        <input class="order-control" type="number" value="${index + 1}" min="1">
                    </td>
                `;
                // Adds an event listener to handle order changes
                row.querySelector('input').addEventListener('change', () => {
                    const newOrder = parseInt(row.querySelector('input').value) - 1;
                    if (newOrder >= 0 && newOrder < imageUrls.length) {
                        const movedImage = imageUrls.splice(index, 1);
                        imageUrls.splice(newOrder, 0, ...movedImage);
                        currentIndex = newOrder;
                        changeImage();
                        populateImageList();
                    }
                });
                // Appends the row to the image list table
                imageList.appendChild(row);
            });
        }

        // Initial image load and image list population
        changeImage();
        populateImageList();

        // Change image every 3 seconds (adjust as needed)
        setInterval(changeImage, 3000);
    </script>
</body>
</html>
```


**javascript**

```javascript
// Array of image URLs
const imageUrls = [
    'https://images.unsplash.com/photo-1594476664296-8c552053aef3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2080&q=80',
    'https://images.unsplash.com/photo-1602015103066-f45732e2aa84?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2080&q=80',
    'https://images.unsplash.com/photo-1604922824961-87cefb2e4b07?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2080&q=80',
    // Add more image URLs as needed
];

const sliderImage = document.getElementById('sliderImage');
const imageList = document.getElementById('imageList');
let currentIndex = 0;

// Function to change the image
function changeImage() {
    sliderImage.src = imageUrls[currentIndex];
    currentIndex = (currentIndex + 1) % imageUrls.length; // Loop through images
}

// Populate the image list table
function populateImageList() {
    imageList.innerHTML = '';
    imageUrls.forEach((imageUrl, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${index}</td>
            <td><img src="${imageUrl}" alt="Image ${index}" width="50"></td>
            <td>
                <input class="order-control" type="number" value="${index + 1}" min="1">
            </td>
        `;
        row.querySelector('input').addEventListener('change', () => {
            const newOrder = parseInt(row.querySelector('input').value) - 1;
            if (newOrder >= 0 && newOrder < imageUrls.length) {
                const movedImage = imageUrls.splice(index, 1);
                imageUrls.splice(newOrder, 0, ...movedImage);
                currentIndex = newOrder;
                changeImage();
                populateImageList();
            }
        });
        imageList.appendChild(row);
    });
}

// Initial image load and image list population
changeImage();
populateImageList();

// Change image every 3 seconds (adjust as needed)
setInterval(changeImage, 3000);
```

Here's a step-by-step explanation of the JavaScript code:

1. **Array of Image URLs**: An array named `imageUrls` is defined, which contains URLs of the images you want to display in the slider. You can add or remove image URLs as needed.

2. **Element Selection**: The code selects HTML elements using `document.getElementById`. `sliderImage` represents the `img` element where the slider image will be displayed, and `imageList` represents the `tbody` element of the image list table.

3. **changeImage Function**: This function is responsible for changing the image displayed in the slider. It sets the `src` attribute of the `sliderImage` element to the URL of the current image in the `imageUrls` array. The `currentIndex` is used to keep track of which image is currently displayed, and it wraps around when reaching the end of the array.

4. **populateImageList Function**: This function populates the image list table with rows, each containing the index, a thumbnail image, and an input field to control the order of images. Event listeners are added to the input fields to update the order of images in the `imageUrls` array when changed.

5. **Initial Image Load and Image List Population**: `changeImage` is called to load the initial image. `populateImageList` is called to create the image list table.

6. **Interval for Image Change**: `setInterval` is used to call the `changeImage` function every 3 seconds, causing the slider to automatically transition to the next image.

**Laravel project link : [Click ME](https://github.com/tahsin-liberate/Dynamic-Image-Slider)**
