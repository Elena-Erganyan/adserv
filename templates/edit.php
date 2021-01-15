<?php if (isset($user)): ?>
<?php $classname = count($errors) ? "form--invalid" : "" ; 
    $id = isset($_GET["id"]) ? $_GET["id"] : "";
?>
<form class="form form--add-lot container <?=$classname; ?>" action="./edit.php?id=<?=$id; ?>" method="post" enctype="multipart/form-data">
    <h2>Editing an ad</h2>
    <div class="form__container-two">

      <?php $classname = isset($errors["title"]) ? "form__item--invalid" : "";
      $value = $ad["title"] ?? "";
      $message = $errors["title"] ?? ""; ?>

      <div class="form__item <?=$classname; ?>">
        <label for="title">Title*</label>
        <input id="title" type="text" name="title" placeholder="Enter the name of the product or service" value="<?=$value; ?>">
        <span class="form__error"><?=$message; ?></span>
      </div>

      <?php $classname = isset($errors["category"]) ? "form__item--invalid" : "";
       $value = $ad["category"] ?? $ad["cat_name"];
       $message = $errors["category"] ?? ""; ?>

      <div class="form__item <?=$classname; ?>">
        <label for="category">Category*</label>
        <select id="category" name="category">
          <option>Select a category</option>
          <? foreach($categories as $category) : ?>
          <?php $selected = ($value == $category["name"]) ? "selected" : ""; ?>
          <option <?=$selected; ?>><?=$category["name"]; ?></option>
          <? endforeach; ?>
        </select>
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <?php $classname = isset($errors["description"]) ? "form__item--invalid" : "";
    $value = $ad["description"] ?? "";
    $message = $errors["description"] ?? ""; ?>

    <div class="form__item form__item--wide <?=$classname; ?>">
      <label for="description">Description*</label>
      <textarea id="description" name="description" placeholder="Enter a description"><?=$value; ?></textarea>
      <span class="form__error"><?=$message; ?></span>
    </div>

    <?php $classname = !isset($ad["img"]) ? "form__item--invalid" : "form__item--uploaded";
    $message = $errors["img"] ?? "";
    $img = $ad["img"] ?? ""; ?>
    <div class="form__item form__item--file <?=$classname; $uploaded; ?>">
      <label>Image</label>
      <div class="form__input-file" id="file">
        <input class="visually-hidden" type="file" name="img" id="img" value="<?=$img;?>">
        <label class="btn btn--light hidden" id="imgLabel" for="img"><span>+ Add an image</span></label>
        <div class="preview" id="preview">
            <img src="<?=$ad["img"];?>" width="150" alt="">
            <button class="form__btn btn btn--light" id="delete" type="button">Delete</button>
        </div>
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <div class="form__container-three">

      <?php $classname = isset($errors["price"]) ? "form__item--invalid" : "";
      $value = $ad["price"] ?? "";
      $message = $errors["price"] ?? ""; ?>

      <div class="form__item form__item--small <?=$classname; ?>">
        <label for="price">Price*, rub.</label>
        <input id="price" type="number" name="price" placeholder="0" value="<?=$value; ?>">
        <span class="form__error"><?=$message; ?></span>
      </div>
    </div>

    <?php $message = count($errors) ? "Please correct the errors in the form" : "" ; ?>
    <span class="form__error form__error--bottom"><?=$message; ?></span>
    <button class="form__btn btn" type="submit">Save an ad</button>
</form>
<?php else: ?>
    <h1>Error 403: Access denied</h1>
<?php endif; ?>
