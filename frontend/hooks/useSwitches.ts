// frontend/hooks/useSwitches.ts
import { useState, useEffect } from 'react';
import { apiClient } from '@/lib/api';
import { KeySwitch } from '@/lib/types';

interface UseSwitchesParams {
  search?: string;
  type?: string[];
  brand?: string[];
  price?: string[];
  sort?: string;
  order?: 'asc' | 'desc';
}

export function useSwitches(params: UseSwitchesParams = {}) {
  const [switches, setSwitches] = useState<KeySwitch[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const fetchSwitches = async () => {
      try {
        setLoading(true);
        setError(null);
        const response = await apiClient.getSwitches(params);
        setSwitches(response.data);
      } catch (err) {
        setError(err instanceof Error ? err.message : 'データの取得に失敗しました');
        console.error('Failed to fetch switches:', err);
      } finally {
        setLoading(false);
      }
    };

    fetchSwitches();
  }, [
    params.search,
    params.type?.join(','),
    params.brand?.join(','),
    params.price?.join(','),
    params.sort,
    params.order,
  ]);

  return { switches, loading, error };
}