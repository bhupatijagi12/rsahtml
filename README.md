# GlobalAid Assurance — RSA Portal (Front-End Prototype)

A static, Bootstrap 5.3-based front-end for a Roadside Assistance (RSA) portal, branded for GlobalAid Assurance.

## Pages
- `index.html` — Home
- `login.html` — Log in with mobile number + OTP (simulated, no backend)
- `register.html` — Registration with basic info
- `dealer-onboarding.html` — 4-step dealer onboarding form
- `policy-download.html` — Look up and download a policy by policy number or mobile number
- `get-policy.html` — Choose a plan and issue a new RSA policy

## How to use
Open `index.html` in any browser — no build step or server required. All pages link to each other via the top navigation.

## Notes
- This is a front-end only prototype: forms simulate success states with JavaScript and do not call a real backend or send actual OTPs/emails. Wire up `assets/js` (or inline scripts in each page) to your API/OTP provider to make it functional.
- Uses Bootstrap 5.3.3 and Bootstrap Icons via CDN, plus Google Fonts (Poppins + Inter). An internet connection is needed for these to load; swap in local copies if you need it fully offline.
- Brand colors and the logo (`assets/images/logo.jpg`) are pulled from the GlobalAid Assurance logo you supplied.
- Sample policy numbers, prices and coverage details are illustrative placeholders — replace with real product data before going live.

## Structure
```
rsa-portal/
├── index.html
├── login.html
├── register.html
├── dealer-onboarding.html
├── policy-download.html
├── get-policy.html
├── assets/
│   ├── css/style.css
│   ├── js/          (reserved for future shared scripts)
│   └── images/logo.jpg
└── README.md
```
