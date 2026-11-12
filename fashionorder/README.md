# FashionOrder

A React + Vite storefront for Nigerian native wear, custom tailoring and boutique fashion.

## Features
- Responsive storefront with Nigerian fashion collections
- Category filters and product search
- Interactive shopping bag with quantity controls
- WhatsApp order handoff
- Custom tailoring request form
- Naira pricing and nationwide delivery messaging

## Run locally
```bash
npm install
npm run dev
```

## Build
```bash
npm run build
npm run preview
```

## Deploy on Vercel
Import this GitHub repository, choose the `fashionorder` branch, set **Root Directory** to `fashionorder`, and deploy with the Vite defaults. The included `vercel.json` specifies the build and output settings.

The current ordering flow opens WhatsApp with the customer's order details. Connect the business WhatsApp number and payment/order backend before accepting live customer orders.