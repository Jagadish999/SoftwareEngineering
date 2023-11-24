<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/addCategory.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>


    @include('partials.adminnavigation')
    @include('partials.adminaddcategorycontain')

    <script src = "/js/script.js"></script>

    <script>
        function addProperty() {
            const categoryProperties = document.getElementById("categoryProperties");

            const propertyContainer = document.createElement("div");
            propertyContainer.classList.add("category-property");

            const propertyNameInput = document.createElement("input");
            propertyNameInput.setAttribute("type", "text");
            propertyNameInput.setAttribute("class", "category-property-input");
            propertyNameInput.setAttribute("name", "propertyNames[]");
            propertyNameInput.setAttribute("placeholder", "Property Name");
            propertyNameInput.required = true;

            // Datatype selection (number, text, large text)
            const datatypeSelect = document.createElement("select");
            datatypeSelect.setAttribute("class", "category-property-select");
            datatypeSelect.setAttribute("name", "datatypes[]");
            datatypeSelect.required = true;

            const numberOption = document.createElement("option");
            numberOption.value = "number";
            numberOption.text = "Number";

            const textOption = document.createElement("option");
            textOption.value = "text";
            textOption.text = "Text";

            const largeTextOption = document.createElement("option");
            largeTextOption.value = "largeText";
            largeTextOption.text = "Large Text";

            datatypeSelect.appendChild(numberOption);
            datatypeSelect.appendChild(textOption);
            datatypeSelect.appendChild(largeTextOption);

            const removeButton = document.createElement("button");
            removeButton.innerHTML = '<i class="fas fa-trash"></i> Remove';
            removeButton.classList.add("remove-property");
            removeButton.type = "button";
            removeButton.addEventListener("click", function () {
                categoryProperties.removeChild(propertyContainer);
            });

            propertyContainer.appendChild(propertyNameInput);
            propertyContainer.appendChild(datatypeSelect);
            propertyContainer.appendChild(removeButton);

            categoryProperties.appendChild(propertyContainer);
        }

        document.getElementById("addProperty").addEventListener("click", addProperty);

    </script>

</body>
</html>