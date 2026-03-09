<!--Mathew Boullier-->
<!--03/08/26-->
<!--PHP footer partial.-->

<!--Accepts:-->
<!--$pageScript: path to a .js file that the page requires to run. Can be null.-->

<?php if (!empty($pageScript)): ?>
    <script src="js/<?= $pageScript ?>"></script>
<?php endif; ?>
</body>
</html>