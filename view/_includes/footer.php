
        </main>

        <div class="leaves left pos-absolute d-block d-md-none desktop">
            <img src="<?php echo IMAGES; ?>leaves.png" alt="" width="264" height="590">
        </div>

        <div class="leaves right pos-absolute d-block d-md-none desktop">
            <img src="<?php echo IMAGES; ?>leaves.png" alt="" width="264" height="590">
        </div>

        <?php if ($site->getController() == 'index' or $site->getController() == 'conta'): ?>
        <div class="leaves pos-absolute mb d-none d-md-flex ai-center jc-center mobile bottom">
            <img src="<?php echo IMAGES; ?>folhagem.png" alt="" width="1026" height="502">
        </div>
        <?php endif ?>

        <?php if ($hasFooter): ?>
        <footer class="d-flex ai-center jc-center">
            <p>Desenvolvido por <strong>Blando Alexandre</strong></p>
        </footer>
        <?php endif; ?>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="<?php echo SCRIPT; ?>library.js"></script>
        <script src="<?php echo SCRIPT; ?>main.js"></script>
    </body>
</html>

