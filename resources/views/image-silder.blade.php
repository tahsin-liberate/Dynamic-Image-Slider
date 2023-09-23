<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Slider with Image List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        /* CSS for styling the slider and image list */

        .slider-image {
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease-in-out;
        }

        .slider-container {
            position: relative;
            width: 100%;
            /* You can adjust the width as needed */
            overflow: hidden;
            max-height: 300px;
            /* You can adjust the height as needed */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        td img {
            max-width: 100%;
            height: auto;
        }

        td form {
            margin: 0;
        }

        td button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        td button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="slider-container ">
                    <img class="slider-image" id="sliderImage" src="" alt="Slider Image">
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="text-center">Create Image</h2>
                <form method="POST" action="{{ route('image_slider.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="imageUrl">Image URL:</label>
                        <input type="url" class="form-control" name="image_url" placeholder="Enter image URL">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Image</button>
                </form>
            </div>
        </div>
        <div class="row mt-5 mb-5">
            <div class="col-md-12">
                <h2 class="text-center">Image List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Seq</th>
                            <th>Image</th>
                            <th>Order</th>
                            <th>State</th>
                        </tr>
                    </thead>
                    <tbody id="imageList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <script>
        // Array of image URLs
        const imageUrls = @json($images);
        console.log(imageUrls);


        const sliderImage = document.getElementById('sliderImage');
        const imageList = document.getElementById('imageList');
        let currentIndex = 0;

        function changeImage() {
            sliderImage.src = imageUrls[currentIndex].image_url;
            currentIndex = (currentIndex + 1) % imageUrls.length; // Loop through images
        }

        function populateImageList() {
            imageList.innerHTML = '';
            imageUrls.forEach((imageUrl, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td width="10">${index + 1}</td>
                    <td><img src="${imageUrl.image_url}" alt="Image ${index}" width="50"></td>
                    <td>
                        <form method="POST" action="/update-orders/${imageUrl.id}">
                            @csrf
                            <input type="number" name="input_name" oninput="this.form.submit()">
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="/image-slider/${imageUrl.id}" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="number" class="btn btn-danger">Delete</button>
                        </form>
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
    </script>
</body>

</html>
