/**
 * Form validation and submission handling
 * Version compatible avec FormSubmit
 */

(function () {
  "use strict";

  let forms = document.querySelectorAll(".php-email-form");

  forms.forEach(function (form) {
    form.addEventListener("submit", function (event) {
      // Ne pas intercepter la soumission - laisser FormSubmit gérer cela

      // Afficher le message de chargement
      this.querySelector(".loading").classList.add("d-block");

      // Masquer les messages d'erreur et de succès
      this.querySelector(".error-message").classList.remove("d-block");
      this.querySelector(".sent-message").classList.remove("d-block");

      // Effectuer une validation basique côté client
      const isValid = validateForm(this);

      if (!isValid) {
        event.preventDefault(); // Empêcher la soumission si le formulaire n'est pas valide
        this.querySelector(".loading").classList.remove("d-block");
      }
    });
  });

  function validateForm(form) {
    // Récupérer les champs du formulaire
    const nameField = form.querySelector('input[name="name"]');
    const emailField = form.querySelector('input[name="email"]');
    const subjectField = form.querySelector('input[name="subject"]');
    const messageField = form.querySelector('textarea[name="message"]');

    // Vérifier si les champs obligatoires sont remplis
    if (!nameField.value.trim()) {
      displayError(form, "Veuillez entrer votre nom.");
      return false;
    }

    if (!emailField.value.trim()) {
      displayError(form, "Veuillez entrer votre adresse email.");
      return false;
    }

    // Validation simple du format email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailField.value.trim())) {
      displayError(form, "Veuillez entrer une adresse email valide.");
      return false;
    }

    if (!subjectField.value.trim()) {
      displayError(form, "Veuillez entrer un sujet.");
      return false;
    }

    if (!messageField.value.trim()) {
      displayError(form, "Veuillez entrer votre message.");
      return false;
    }

    return true;
  }

  function displayError(form, error) {
    form.querySelector(".loading").classList.remove("d-block");
    form.querySelector(".error-message").innerHTML = error;
    form.querySelector(".error-message").classList.add("d-block");
  }
})();
