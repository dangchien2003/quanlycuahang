    <script src="../../public/js/bootstrap.min.js?v=<?php echo filemtime('../../public/js/bootstrap.min.js')?>"></script>
    <script src="../../public/js/jquery.js?v=<?php echo filemtime('../../public/js/jquery.js')?>"></script>
    <script src="../../public/js/menu.js?v=<?php echo filemtime('../../public/js/menu.js')?>"></script>
    <script src="../../public/js/app.js?v=<?php echo filemtime('../../public/js/app.js')?>"></script>
    <script src="../../public/js/toast.js?v=<?php echo filemtime('../../public/js/toast.js')?>"></script>
    <script src="../../public/js/calc.js?v=<?php echo filemtime('../../public/js/calc.js')?>"></script>
    <?php 
        function addScript($name) {
            foreach($name as $script) {
                echo '<script src="'.'../../public/js/'.$script.'.js?v='. filemtime('../../public/js/'.$script.'.js').'></script>';    
            }
        }
    ?> 
</body>

</html>