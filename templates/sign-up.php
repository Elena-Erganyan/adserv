<?php $classname = count($errors) ? "form--invalid" : ""; ?>
  <form class="form container <?=$classname; ?>" action="sign-up.php" method="post">
    <h2>New account registration</h2>
    <?php $classname = isset($errors["email"]) ? "form__item--invalid" : "";
    $value = $_POST["email"] ?? "";
    $message = $errors["email"] ?? ""; ?>
    <div class="form__item <?=$classname; ?>">
      <label for="email">E-mail*</label>
      <input id="email" type="email" name="email" placeholder="Enter your e-mail" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>
    <?php $classname = isset($errors["password"]) ? "form__item--invalid" : "";
    $value = $_POST["password"] ?? "";
    $message = $errors["password"] ?? ""; ?>
    <div class="form__item <?=$classname; ?>">
      <label for="password">Password*</label>
      <input id="password" type="password" name="password" placeholder="Enter your password" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>
    <?php $classname = isset($errors["name"]) ? "form__item--invalid" : "";
    $value = $_POST["name"] ?? "";
    $message = $errors["name"] ?? ""; ?>
    <div class="form__item <?=$classname; ?>">
      <label for="name">Name*</label>
      <input id="name" type="text" name="name" placeholder="Enter your name" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>
    <?php $classname = isset($errors["phone"]) ? "form__item--invalid" : "";
    $value = $_POST["phone"] ?? "";
    $message = $errors["phone"] ?? ""; ?>
    <div class="form__item <?=$classname; ?>">
      <label for="name">Phone number*</label>
      <input id="phone" type="tel" name="phone" placeholder="Enter your phone number in the format +79001234567" value="<?=$value; ?>">
      <span class="form__error"><?=$message; ?></span>
    </div>
    <span class="form__error form__error--bottom">Please correct the errors in the form</span>
    <button type="submit" class="btn">Sign up</button>
    <a class="form__link" href="sign-in.php">Already have an account</a>
  </form>