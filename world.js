document.addEventListener("DOMContentLoaded", () => {
  const lookupCountryButton = document.getElementById("lookup-country");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  lookupCountryButton.addEventListener("click", () => {
    const country = countryInput.value.trim();
    const url = `world.php?country=${encodeURIComponent(country)}`;

    fetch(url)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok");
        }
        return response.text();
      })
      .then((data) => {
        resultDiv.innerHTML = data;
      })
      .catch((error) => {
        console.error("Fetch error:", error);
        resultDiv.innerHTML =
          "<p>Error retrieving data. Please try again later.</p>";
      });
  });
});
