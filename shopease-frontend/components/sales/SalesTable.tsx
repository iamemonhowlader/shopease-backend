"use client";

import { Sale } from "@/lib/types";
import { format } from "date-fns";
import { Loader2, AlertCircle, ShoppingCart } from "lucide-react";

interface Props {
  sales: Sale[];
  isLoading: boolean;
  isError: boolean;
}

export default function SalesTable({ sales, isLoading, isError }: Props) {
  if (isError) {
    return (
      <div className="p-20 text-center space-y-4">
        <div className="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto text-red-600">
          <AlertCircle className="w-8 h-8" />
        </div>
        <h3 className="text-xl font-bold text-slate-900">Failed to load sales</h3>
        <p className="text-slate-500">Could not connect to the server. Please check your connection.</p>
      </div>
    );
  }

  if (isLoading) {
    return (
      <div className="p-20 text-center space-y-4">
        <Loader2 className="w-12 h-12 animate-spin mx-auto text-blue-500" />
        <p className="text-slate-500 font-medium">Fetching sales records...</p>
      </div>
    );
  }

  if (sales.length === 0) {
    return (
      <div className="p-20 text-center space-y-4">
        <div className="bg-slate-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto text-slate-400">
          <ShoppingCart className="w-8 h-8" />
        </div>
        <h3 className="text-xl font-bold text-slate-900">No sales found</h3>
        <p className="text-slate-500">Try adjusting your filters to find what you're looking for.</p>
      </div>
    );
  }

  return (
    <div className="overflow-x-auto">
      <table className="w-full text-left border-collapse">
        <thead>
          <tr className="bg-slate-50 border-b border-slate-100">
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Sale ID</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Branch</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Product</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Category</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Qty</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Price</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Discount</th>
            <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Revenue</th>
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-50">
          {sales.map((sale) => (
            <tr key={sale.id} className="hover:bg-blue-50/30 transition-colors group">
              <td className="px-6 py-4 text-sm font-bold text-slate-900">{sale.sale_id}</td>
              <td className="px-6 py-4">
                <span className="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                  {sale.branch}
                </span>
              </td>
              <td className="px-6 py-4 text-sm text-slate-600">
                {format(new Date(sale.sale_date), "dd MMM yyyy")}
              </td>
              <td className="px-6 py-4 text-sm font-medium text-slate-900">{sale.product_name}</td>
              <td className="px-6 py-4">
                <span className="text-sm text-slate-500 italic">
                  {sale.category || "N/A"}
                </span>
              </td>
              <td className="px-6 py-4 text-sm font-bold text-slate-900 text-right">{sale.quantity}</td>
              <td className="px-6 py-4 text-sm text-slate-600 text-right">৳{parseFloat(sale.unit_price).toLocaleString()}</td>
              <td className="px-6 py-4 text-sm text-orange-600 font-bold text-right">
                {(parseFloat(sale.discount_pct) * 100).toFixed(0)}%
              </td>
              <td className="px-6 py-4 text-sm font-black text-blue-600 text-right">৳{parseFloat(sale.revenue).toLocaleString()}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
