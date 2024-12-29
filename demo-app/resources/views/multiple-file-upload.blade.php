<!DOCTYPE html>
<html>
   <head>
      <title>Laravel 9 Multiple File Upload Tutorial With Example - ScratchCode.io</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
      <script src="https://cdn.tailwindcss.com"></script>
    </head>
   <body>
      <div class="container">
         <div class="panel panel-primary">
            <div class="panel-body">
               @if ($message = Session::get('success'))
                   <div class="alert alert-success alert-block">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>{{ $message }}</strong>
                   </div>
               @endif

               @if (count($errors) > 0)
               <div class="alert alert-danger">
                  <strong>Whoops!</strong> There were some problems with your input.
                  <ul>
                     @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                     @endforeach
                  </ul>
               </div>
               @endif

               <form class="w-full h-screen flex justify-center items-center" action="{{ route('store.multiple-files') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="text" id="hiddenFile" name="hiddenFile" value="">
                  <div>
                    <div id="uploadedFiles" class="overflow-hidden">

                    </div>
                    <div id="dropdownFile">
                        <div id="uploadFileContainer" class="h-10 overflow-hidden">
                            <div class="file-upload flex items-center space-x-2">
                                <label for="uploadFile" class="flex p-1 px-5 mx-auto text-sm text-left border rounded-full cursor-pointer w-fit border-primary text-primary focus:outline-none">
                                    <span>Browse File</span>
                                </label>
                                <input type="file" id="uploadFile" name="documents[]" data-image-upload="upload" class="hidden" multiple onchange="handleFileUpload(event)" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Upload Files...</button>
                    </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </body>
   <script>
       let uploadedFiles = [];
        // Function to handle initial file upload and display file list
        function handleFileUpload(event) {
            const files = event.target.files;
            for (let file of files) {
                if (!uploadedFiles.some(f => f.name === file.name && f.size === file.size)) {
                    uploadedFiles.push(file);
                }
            }
            // addFileInput();
            renderUploadedFiles();
            addMoreFileInputs();
        }

        let i = 1;
        function addMoreFileInputs() {
            const container = document.getElementById('uploadFileContainer');
            container.insertAdjacentHTML('beforebegin', `
                <div class="file-upload flex items-center space-x-2">
                    <label for="uploadDocument${i}" class="flex p-1 px-5 mx-auto text-sm text-left border rounded-full cursor-pointer w-fit border-primary text-primary focus:outline-none">
                        <span>Browse File</span>
                    </label>
                    <input type="file" id="uploadDocument${i}" name="documents[]" class="hidden" multiple onchange="handleFileUpload(event)" />
                </div>
            `);
            i++;
        }

        // Make the function globally accessible
        window.handleFileUpload = handleFileUpload;
        let number = 1;
        function renderUploadedFiles() {
        const uploadedFilesContainer = document.getElementById('uploadedFiles');
        uploadedFilesContainer.innerHTML = '';
        if (uploadedFiles.length === 0) {
            uploadedFilesContainer.innerHTML = `
                <div class="flex flex-col items-center justify-center gap-2">
                    <div class="w-9 h-9 text-primary">
                        <svg
                            class="w-9 h-9"
                            viewBox="0 0 34 34"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.7582 26.9963H8.11817C4.07567 26.7075 2.26074 23.6 2.26074 20.8363C2.26074 18.0725 4.07569 14.9513 8.04944 14.6763C8.61319 14.6213 9.10817 15.0613 9.14942 15.6388C9.19067 16.2025 8.76449 16.6975 8.18699 16.7388C5.51949 16.9313 4.32324 18.9388 4.32324 20.85C4.32324 22.7613 5.51949 24.7688 8.18699 24.9613H10.7582C11.322 24.9613 11.7895 25.4288 11.7895 25.9925C11.7895 26.5563 11.322 26.9963 10.7582 26.9963Z" fill="currentColor"/>
                            <path d="M23.421 26.9962C23.3935 26.9962 23.3798 26.9962 23.3523 26.9962C22.7885 26.9962 22.266 26.5287 22.266 25.965C22.266 25.3737 22.706 24.9337 23.2835 24.9337C24.9748 24.9337 26.4873 24.3425 27.6698 23.2837C29.8148 21.4137 29.9523 18.7187 29.3748 16.8212C28.7973 14.9375 27.1885 12.7787 24.3835 12.435C23.9298 12.38 23.5722 12.0362 23.4897 11.5825C22.9397 8.28249 21.166 5.99999 18.471 5.17499C15.6935 4.30874 12.4485 5.16124 10.4272 7.27874C8.46097 9.32749 8.00723 12.2012 9.14848 15.3637C9.34098 15.9 9.06605 16.4912 8.5298 16.6837C7.99355 16.8762 7.40227 16.6012 7.20977 16.065C5.82102 12.1875 6.45353 8.47499 8.94228 5.86249C11.486 3.19499 15.5698 2.13623 19.076 3.20873C22.2935 4.19873 24.5622 6.85248 25.3872 10.5375C28.1922 11.17 30.4472 13.3012 31.341 16.2437C32.3172 19.4475 31.4373 22.7475 29.031 24.8375C27.5048 26.2125 25.511 26.9962 23.421 26.9962Z" fill="currentColor"/>
                            <path d="M17 31.0388C14.2363 31.0388 11.6513 29.5675 10.235 27.1888C10.0838 26.955 9.93253 26.68 9.80878 26.3775C9.34128 25.4013 9.09375 24.2875 9.09375 23.1325C9.09375 18.7738 12.6413 15.2263 17 15.2263C21.3588 15.2263 24.9063 18.7738 24.9063 23.1325C24.9063 24.3013 24.6588 25.4013 24.1638 26.4188C24.0538 26.68 23.9025 26.955 23.7375 27.2163C22.3488 29.5675 19.7638 31.0388 17 31.0388ZM17 17.2888C13.7825 17.2888 11.1563 19.915 11.1563 23.1325C11.1563 23.985 11.335 24.7825 11.6788 25.5113C11.7888 25.745 11.885 25.9375 11.995 26.1163C13.04 27.89 14.9512 28.9763 16.9862 28.9763C19.0212 28.9763 20.9325 27.89 21.9637 26.1438C22.0875 25.9375 22.1975 25.745 22.28 25.5525C22.6513 24.7963 22.83 23.9988 22.83 23.1463C22.8437 19.915 20.2175 17.2888 17 17.2888Z" fill="currentColor"/>
                            <path d="M16.2162 25.5249C15.955 25.5249 15.6938 25.4287 15.4875 25.2224L14.1262 23.8612C13.7275 23.4624 13.7275 22.8024 14.1262 22.4037C14.525 22.0049 15.185 22.0049 15.5837 22.4037L16.2438 23.0637L18.4437 21.0287C18.87 20.6437 19.5162 20.6712 19.9012 21.0837C20.2862 21.4962 20.2588 22.1562 19.8463 22.5412L16.9175 25.2499C16.7113 25.4287 16.4637 25.5249 16.2162 25.5249Z" fill="currentColor"/>
                        </svg>
                    </div>
                    <p>No files uploaded yet.</p>
                </div>`;
            return;
        }
        uploadedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.classList.add('flex', 'items-center', 'justify-between', 'p-2', 'border-b');
            // File icon and name
            const fileInfo = document.createElement('div');
            fileInfo.classList.add('flex', 'items-center', 'gap-2');
            const fileIcon = document.createElement('div');
            fileIcon.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="19" viewBox="0 0 25 19" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5 2C4.17157 2 3.5 2.67157 3.5 3.5V15.5C3.5 16.3284 4.17157 17 5 17H20C20.8284 17 21.5 16.3284 21.5 15.5V3.5C21.5 2.67157 20.8284 2 20 2H5ZM2 3.5C2 1.84315 3.34315 0.5 5 0.5H20C21.6569 0.5 23 1.84315 23 3.5V15.5C23 17.1569 21.6569 18.5 20 18.5H5C3.34315 18.5 2 17.1569 2 15.5V3.5Z" fill="#AB2325"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16.25 5C15.8358 5 15.5 5.33579 15.5 5.75C15.5 6.16421 15.8358 6.5 16.25 6.5C16.6642 6.5 17 6.16421 17 5.75C17 5.33579 16.6642 5 16.25 5ZM14 5.75C14 4.50736 15.0074 3.5 16.25 3.5C17.4926 3.5 18.5 4.50736 18.5 5.75C18.5 6.99264 17.4926 8 16.25 8C15.0074 8 14 6.99264 14 5.75Z" fill="#AB2325"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.94598 8.37602C8.37492 7.99521 8.93309 7.79259 9.50642 7.80958C10.0796 7.82657 10.6246 8.06172 11.0302 8.46699L15.2798 12.7087C15.573 13.0013 15.5735 13.4762 15.2808 13.7694C14.9882 14.0625 14.5133 14.063 14.2202 13.7704L9.97005 9.5282C9.83484 9.39302 9.65311 9.31459 9.462 9.30892C9.27092 9.30326 9.0849 9.37077 8.94194 9.49766L3.24835 14.5599C2.9388 14.8351 2.46474 14.8073 2.18951 14.4977C1.91429 14.1882 1.94211 13.7141 2.25167 13.4389L7.94598 8.37602Z" fill="#AB2325"/>
                </svg>`;
            fileIcon.classList.add('w-8', 'h-8', 'flex', 'items-center', 'justify-center');
            // Attach click event for previewing the image
            fileInfo.addEventListener('click', () => previewImage(file));
            const fileName = document.createElement('span');
            fileName.textContent = file.name;
            fileName.classList.add('text-sm', 'font-medium');
            // Append icon and name to fileInfo
            fileInfo.appendChild(fileIcon);
            fileInfo.appendChild(fileName);
            const deleteButtonHTML = `
              <button type="button" onclick="deleteButton('${index}','${file.name}');" type="button" class="text-red-500 hover:text-red-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 16.5C12.4183 16.5 16 12.9183 16 8.5C16 4.08172 12.4183 0.5 8 0.5C3.58172 0.5 0 4.08172 0 8.5C0 12.9183 3.58172 16.5 8 16.5ZM5 7.5C4.44772 7.5 4 7.94772 4 8.5C4 9.05228 4.44772 9.5 5 9.5H11C11.5523 9.5 12 9.05229 12 8.5C12 7.94772 11.5523 7.5 11 7.5H5Z" fill="#EC2227"></path>
                </svg>
              </button>
            `;
            number++;
            const tempContainer = document.createElement('div');
            tempContainer.innerHTML = deleteButtonHTML;
            const deleteButton = tempContainer.firstElementChild;

            fileItem.appendChild(fileInfo);
            fileItem.appendChild(deleteButton);
            uploadedFilesContainer.appendChild(fileItem);
        });

        window.deleteButton = function(index, fileName) {
            const hiddenFile = document.getElementById("hiddenFile");
            let currentValue = hiddenFile.value.trim();// Appends fileName twice
            if (currentValue) {
                currentValue += `, ${fileName}`;
            } else {
                currentValue = fileName;
            }
            hiddenFile.value = currentValue;
                uploadedFiles.splice(index, 1);
                renderUploadedFiles();
            };

        // Function to preview the image
        function previewImage(file) {
            // Allowed preview extensions
            const allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            // Get the file extension
            const fileExtension = file.name.split('.').pop().toLowerCase();
            // Check if the file is a document
            if (!allowedImageExtensions.includes(fileExtension)) {
                downloadDocuments(file);
                return;
            }
            // Create the preview modal
            const previewModal = document.createElement('div');
            previewModal.classList.add('previewImage', 'w-full', 'h-full', 'fixed', 'inset-0', 'flex', 'items-center', 'justify-center', 'bg-black/20', 'z-50');
            const imageContainer = document.createElement('div');
            imageContainer.classList.add('relative', 'w-[28rem]', 'h-[28rem]', 'flex', 'items-center', 'justify-center');
            const previewContent = document.createElement('div');
            previewContent.classList.add('relative', 'h-full', 'bg-white', 'p-5', 'aspect-[4/3]');
            const image = document.createElement('img');
            image.src = URL.createObjectURL(file);
            image.alt = file.name;
            image.classList.add('w-full', 'h-full', 'object-contain', 'rounded-xl');
            // Add event listener to remove the modal
            previewModal.addEventListener('click', () => {
                document.body.removeChild(previewModal);
            });
            previewContent.appendChild(image);
            imageContainer.appendChild(previewContent);
            previewModal.appendChild(imageContainer);
            document.body.appendChild(previewModal);
        }
        // Function to download files
        function downloadDocuments(documents) {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(documents);
            link.download = documents.name;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
   </script>
</html>
