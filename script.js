const form = document.querySelector('form');
const fullName = document.getElementById("name");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const subject = document.getElementById("subject");
const mess = document.getElementById("message");

function sendEmail() {
    const bodyMessage = `Full Name: ${fullName.value} <br> Email: ${email.value} <br> Phone Number: ${phone.value}<br> Message: ${mess.value}`;

    Email.send({
        Host: "smtp.elasticemail.com",
        Username: "journaly82@gmail.com",
        Password: "C46B1812A8E0F19ADCF0670ACBC0D2167C3A",
        To: 'journaly82@gmail.com',
        From: "journaly82@gmail.com",
        Subject: subject.value,
        Body: bodyMessage
    }).then(
        message => {
            console.log("Email send response:", message);
            if (message === 'OK') {
                alert("Your message has been sent successfully.");
            } else {
                alert("There was an issue sending your message. Please try again later.");
            }
        }
    ).catch(error => {
        console.error("Failed to send email:", error);
        alert("Failed to send email. Please try again later.");
    });
}

form.addEventListener("submit", (e) => {
    e.preventDefault();
    sendEmail();
});
