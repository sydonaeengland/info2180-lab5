document.addEventListener("DOMContentLoaded", () => {
  const lookupCountryButton = document.getElementById("lookup-country");
  const lookupCitiesButton = document.getElementById("lookup-cities");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  const performLookup = (lookupType) => {
    const country = countryInput.value.trim();
    const url = `world.php?country=${encodeURIComponent(
      country
    )}&lookup=${lookupType}`;

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
  };

  lookupCountryButton.addEventListener("click", () =>
    performLookup("countries")
  );
  lookupCitiesButton.addEventListener("click", () => performLookup("cities"));
});
