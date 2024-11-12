// index.js
const express = require('express');
const jwt = require('jsonwebtoken');

const app = express();
app.use(express.json());

const secretKey = 'uguijknnmhujnbvmhjn'; // Replace with a secure secret key

// Sample users data (replace this with your database logic)
const users = [
  { id: 1, username: 'admin1', password: 'admin1', role: 'administrator' },
  // Add more user data as needed
];

// Endpoint for token generation
app.post('/generate-token', authenticateAdmin, (req, res) => {
  const { username } = req.user;

  // Generate a new token with an extended expiration time or additional claims if needed
  const token = jwt.sign({ sub: req.user.id, username, role: 'administrator' }, secretKey, { expiresIn: '24h' });

  res.json({ token });
});

// Middleware to authenticate administrators
function authenticateAdmin(req, res, next) {
  const { authorization } = req.headers;

  if (!authorization || !authorization.startsWith('Bearer ')) {
    return res.status(401).json({ error: 'Access denied' });
  }

  const token = authorization.substring(7);
  jwt.verify(token, secretKey, (err, user) => {
    if (err || user.role !== 'administrator') {
      return res.status(403).json({ error: 'Invalid token or insufficient permissions' });
    }

    req.user = user;
    next();
  });
}

const port = 3000;
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
