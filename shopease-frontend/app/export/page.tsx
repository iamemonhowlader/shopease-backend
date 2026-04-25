"use client";

import { useSearchParams } from "next/navigation";
import { useQuery } from "@tanstack/react-query";
import { getSummary } from "@/lib/api";
import ExportControls from "@/components/export/ExportControls";
import { 
  TrendingUp, 
  Package, 
  ShoppingCart, 
  BarChart3, 
  ArrowUpRight 
} from "lucide-react";

export default function ExportPage() {
  const searchParams = useSearchParams();
  
  const activeFilters = {
    branch: searchParams.get("branch"),
    from: searchParams.get("from"),
    to: searchParams.get("to"),
    category: searchParams.get("category"),
    payment_method: searchParams.get("payment_method"),
  };

  const { data: summary, isLoading } = useQuery({
    queryKey: ["summary"],
    queryFn: getSummary,
  });

  return (
    <div className="space-y-8 max-w-6xl mx-auto">
      <div className="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
          <h1 className="text-3xl font-bold text-slate-900">Export & Analytics</h1>
          <p className="text-slate-500 mt-2">Generate reports and view branch performance.</p>
        </div>
        
        <ExportControls filters={activeFilters} />
      </div>

      <div className="bg-blue-600 rounded-3xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl shadow-blue-200">
        <div className="space-y-1 text-center md:text-left">
          <p className="text-blue-100 font-bold uppercase tracking-widest text-xs">Active Filters for Export</p>
          <div className="flex flex-wrap gap-2 mt-2 justify-center md:justify-start">
            {Object.entries(activeFilters).map(([key, value]) => value && (
              <span key={key} className="bg-blue-500/50 px-3 py-1 rounded-full text-sm backdrop-blur-sm border border-blue-400/30">
                <span className="opacity-60 capitalize">{key}:</span> {value}
              </span>
            ))}
            {!Object.values(activeFilters).some(Boolean) && (
              <span className="text-blue-100/60 italic">No active filters (Exporting all data)</span>
            )}
          </div>
        </div>
        <div className="text-right">
          <p className="text-blue-100 text-sm font-medium mb-1">Estimated volume</p>
          <p className="text-4xl font-black">~{summary?.total_orders.toLocaleString() || "0"} <span className="text-lg font-bold opacity-60">Rows</span></p>
        </div>
      </div>

      {isLoading ? (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 animate-pulse">
          {[1, 2, 3].map(i => <div key={i} className="h-32 bg-white rounded-3xl border border-slate-100" />)}
        </div>
      ) : summary && (
        <>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <div className="bg-green-100 p-2 rounded-xl text-green-600">
                  <TrendingUp className="w-6 h-6" />
                </div>
                <span className="text-green-500 text-xs font-bold bg-green-50 px-2 py-1 rounded-lg flex items-center gap-1">
                  <ArrowUpRight className="w-3 h-3" /> 12%
                </span>
              </div>
              <p className="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Revenue</p>
              <p className="text-3xl font-black text-slate-900 mt-1">৳{summary.total_revenue.toLocaleString()}</p>
            </div>

            <div className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <div className="bg-blue-100 p-2 rounded-xl text-blue-600">
                  <ShoppingCart className="w-6 h-6" />
                </div>
              </div>
              <p className="text-slate-500 text-sm font-bold uppercase tracking-wider">Total Orders</p>
              <p className="text-3xl font-black text-slate-900 mt-1">{summary.total_orders.toLocaleString()}</p>
            </div>

            <div className="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
              <div className="flex items-center justify-between mb-4">
                <div className="bg-orange-100 p-2 rounded-xl text-orange-600">
                  <BarChart3 className="w-6 h-6" />
                </div>
              </div>
              <p className="text-slate-500 text-sm font-bold uppercase tracking-wider">Avg Order Value</p>
              <p className="text-3xl font-black text-slate-900 mt-1">৳{summary.avg_order_value.toLocaleString()}</p>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div className="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
              <h3 className="text-xl font-bold text-slate-900 mb-6">Top 5 Products</h3>
              <div className="space-y-4">
                {summary.top_products.map((product, i) => (
                  <div key={i} className="flex items-center justify-between group">
                    <div className="flex items-center gap-4">
                      <span className="w-8 h-8 flex items-center justify-center bg-slate-50 rounded-lg text-sm font-bold text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors">
                        {i + 1}
                      </span>
                      <p className="font-bold text-slate-700">{product.product_name}</p>
                    </div>
                    <p className="font-black text-slate-900">৳{parseFloat(product.total_revenue).toLocaleString()}</p>
                  </div>
                ))}
              </div>
            </div>

            <div className="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
              <h3 className="text-xl font-bold text-slate-900 mb-6">Branch Breakdown</h3>
              <div className="overflow-x-auto">
                <table className="w-full text-left">
                  <thead>
                    <tr className="border-b border-slate-50">
                      <th className="pb-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Branch</th>
                      <th className="pb-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Orders</th>
                      <th className="pb-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Revenue</th>
                    </tr>
                  </thead>
                  <tbody className="divide-y divide-slate-50">
                    {summary.branch_breakdown.map((branch, i) => (
                      <tr key={i} className="group hover:bg-slate-50/50 transition-colors">
                        <td className="py-4 font-bold text-slate-700">{branch.branch}</td>
                        <td className="py-4 text-right text-slate-600 font-medium">{branch.orders_count.toLocaleString()}</td>
                        <td className="py-4 text-right font-black text-blue-600">৳{parseFloat(branch.total_revenue).toLocaleString()}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </>
      )}
    </div>
  );
}
