import { useState } from "react";
import reactLogo from "./assets/react.svg";
import viteLogo from "/vite.svg";
// import FormValidationExample from "./FormValidationExample";
import "./App.css";

function App() {
  const [formData, setFormData] = useState({
    username: "",
    email: "",
    password: "",
    confirmPassword: "",
  });

  //setting up state variable errors to manage form validation errors
  const [errors, setErrors] = useState({});

  //setting up formStatus to manage form validation errors
  const [formStatus, setFormStatus] = useState({
    passwordsMatch: false,
    passwordLength: false,
    isSubmitButtonEnabled: false,
  });

  // Validation logic moved to a separate function
  const validateForm = (updatedData) => {
    // Check if passwords match after state update
    const passwordsMatch = updatedData.password === updatedData.confirmPassword;
    //Check if password is at least 6 characters
    const passwordLength = updatedData.password.length >= 6;
    // Check if all fields are filled after state update
    const allFieldsFilled = Object.values(updatedData).every((value) =>
      Boolean(value.trim())
    );

    setErrors((prevErrors) => ({
      ...prevErrors,
      username: updatedData.username ? null : "Name is required",
      email: updatedData.email
        ? !/\S+@\S+\.\S+/.test(updatedData.email)
          ? "Email is not valid"
          : null
        : "Email is required",
      password: updatedData.password
        ? !passwordLength
          ? "Password should have at least 6 characters"
          : null
        : "Password is required",
      confirmPassword: !passwordsMatch ? "Passwords do not match" : "",
    }));

    setFormStatus({
      passwordsMatch,
      passwordLength,
      isSubmitButtonEnabled:
        allFieldsFilled && passwordsMatch && passwordLength,
    });
  };

  //handleChange function is used to update the formData state based on the user input in the form fields
  const handleChange = (event) => {
    //extract the name (input fields) and value (user input) from the event target
    const { name, value } = event.target;
    setFormData((prevData) => {
      const updatedData = {
        //use ... spread operator to optain the existing data in formData and update the specific input field with the new value
        ...prevData,
        [name]: value.trimStart(),
      };
      validateForm(updatedData);
      return updatedData;
    });
  };

  //handleSubmit function is used to validate the form data when the form is submitted
  const handleSubmit = (event) => {
    //Prevent the default form submission behaviour
    //Check each form field for validation errors based on the defined criteria
    event.preventDefault();
    setFormData((prevData) => {
      const updatedData = {
        //use ... spread operator to optain the existing data in formData and update the specific input field with the new value
        ...prevData,
      };
      // Iterate through formData and trim each value
      for (let key in formData) {
        if (formData.hasOwnProperty(key)) {
          formData[key] = formData[key].trim();
        }
      }
      return updatedData;
    });
    alert("Form has been submitted successfully!");
    console.log(formData);

    // Reset the formData state to clear the form fields
    setFormData({
      username: "",
      email: "",
      password: "",
      confirmPassword: "",
    });
    setFormStatus({
      passwordsMatch: false,
      passwordLength: false,
      isSubmitButtonEnabled: false,
    });
    // Clear the input fields
    event.target.reset();
  };

  return (
    <>
      <form onSubmit={handleSubmit}>
        <label>Username</label>
        <input
          name="username"
          type="text"
          placeholder="username"
          value={formData.username}
          onChange={handleChange}
          required={true}
        />
        {errors.username && <p>{errors.username}</p>}
        <label>Email</label>
        <input
          name="email"
          type="email"
          placeholder="example@gmail.com"
          value={formData.email}
          onChange={handleChange}
          required={true}
        />
        {errors.email && <p>{errors.email}</p>}
        <label>Password</label>
        <input
          name="password"
          type="password"
          placeholder="Password"
          value={formData.password}
          onChange={handleChange}
          required={true}
        />
        {errors.password && <p>{errors.password}</p>}
        <label>Confirm Password</label>
        <input
          name="confirmPassword"
          type="password"
          placeholder="Confirm Password"
          value={formData.confirmPassword}
          onChange={handleChange}
          required={true}
        />
        {errors.confirmPassword && <p>{errors.confirmPassword}</p>}
        <button
          type="submit"
          disabled={!formStatus.isSubmitButtonEnabled}
          className={formStatus.isSubmitButtonEnabled ? "enabled" : "disabled"}
        >
          Submit
        </button>
      </form>
    </>
  );
}

export default App;