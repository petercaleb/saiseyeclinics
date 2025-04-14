<h1>Forgot Password Email</h1>

<p>Hello,</p>

<p>We received a request to reset your password for your Clinic App account. You can reset your password using the link below:</p>

<p>
  <a href="{{ url(route('users.reset.password', $token)) }}" style="color: #007bff; text-decoration: none; font-weight: bold;">
    Reset Password
  </a>
</p>

<p>If you did not request a password reset, please ignore this email or contact our support team.</p>

<p>Thank you,<br>Clinic App Support Team</p>

<hr>

<p style="font-size: 12px; color: gray;">
  This email was sent from Clinic App. If you need assistance, please contact our support team at 
  <a href="mailto:info@saiseyeclinics.com">info@saiseyeclinics.com</a>.
</p>
