<div class="api-form">
    <div class="left-column">
        <h2>Add new API endpoint</h2>
        <form id="apiForm" action="" method="post">
            <label for="url">URL:</label>
            <input type="text" id="url" name="url" placeholder="Enter API URL" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <input type="submit" value="Submit">
        </form>
    </div>
    <div class="right-column">
        <div class="result-container" id="resultContainer">
            <!-- AJAX result will be displayed here -->
        </div>
    </div>
</div>

