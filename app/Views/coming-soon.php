<?= $this->extend("layouts/app") ?>

<?= $this->section("body") ?>
<?php include APPPATH . 'Views/layouts/sidebar.php'; ?>

<section class="home">

    <div style="max-width: 794px;
            margin: 20px auto 90px;
            background-color: #fff;
            padding: 60px 50px;
            border: 1px solid #000;
            border-radius: 20px;">

      <!-- <div style="    text-align: center;
                    display: flex;
                    margin: 0px 41%;
                    justify-content: center;">
        <img src="https://www.haircompounds.com/cdn/shop/files/HAIR__COMPOUND_LOGO_MH01_1000x1000_CROPED_DOWN.png"
          style="    width: 100%;
                        max-width: 125px;">

      </div> -->


      <div style="text-align: center;margin: auto;">
        <h2 style="color: #000;
                    text-align: center; font-family: 'Trebuchet MS', sans-serif;
                    font-size: 44px;
                    font-style: normal;
                    font-weight: 500;">Coming Soon!</h2>
      </div>
      <!-- <div style="max-width: 650px;text-align: center;margin: auto;">
        <p style="
                    color: #000;
                    text-align: center;
                    font-family: 'Trebuchet MS', sans-serif;
                    font-size: 18px;
                    font-style: normal;
                    font-weight: 500;
                    line-height: 30px;">We're coming soon! We're working hard to give you the best experience.</p>
      </div> -->

    </div>
</section>


<?= $this->endSection() ?>